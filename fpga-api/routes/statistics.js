// Real Time Statistics module

// Package dependencies
var config = require('../config.js');
var common = require('./_common.js');
var statistics_utils = require('./statistics_utils.js');


// Routes

// /ping
// Simple ping
exports.ping = function (req, res) {
  common.sendJSON('statistics_ping', res, 200);
};

// /delay
// Seconds of delay between the client and the server (of timestamps)
exports.delay = function (req, res) {
  var delay = common.getDelay(req);
  if (delay === false) {
    res.sendStatus(400);
  } else {
    common.readJSON('statistics_delay', function (ans) {
      ans.delay = delay;
      ans.maxDelay = config.MAX_DELAY;
      res.status(200).json(ans);
    });
  }
};

// /status
// Status of the FPGA
exports.status = function (req, res) {
  // Finite State Machine. Every transition to a new status (state) is checked with a callback test function
  statistics_utils.nextCallback(res, [
    statistics_utils.hugePagesOn,
    statistics_utils.initializedFPGA,
    statistics_utils.mountedFPGA,
    statistics_utils.statusFPGA
  ]);
};

// /storage/stats
// Statistics of the storage
exports.storageStats = function (req, res) {
  common.readJSON('storage_stats', function (ans) {
    var command = 'df "' + config.CAPTURES_DIR + '" | tail -n1 | awk \'{print $2" "$3}\'';
    scripts.exec(command, function (error, stdout, stderr) {
      if (error) {
        // Internal error
        common.logError(stderr);
        res.sendStatus(500);
        return;
      }
      // Output format:
      // total_bytes used_bytes
      var parts = stdout.split(' ');
      if ((parts == null) || (parts.length < 2)) {
        // Internal error
        common.logError(stderr);
        res.sendStatus(500);
        return;
      }
      // Total space and used space are in KBytes, and output in Bytes
      ans.total_space = parseInt(parts[0])*1024;
      ans.used_space = parseInt(parts[1])*1024;
      // Raid active
      if (config.RAID) {
        // Get individual disk statistics
        ans.raid_stats.raid_active = true;
        statistics_utils.getRaidStats(res, ans);
        return;
      }
      // Raid not active
      ans.raid_stats.raid_active = false;
      common.sendJSON(ans, res, 200);
    });
  });
};