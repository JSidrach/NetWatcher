#!/bin/bash
# Commands
HELP_TEXT='./scripts/build.sh [-d|--doc] [-u|--upgrade] [-i|--install] [-c|--check] [-p|--permissions] [-u|--update] [-r|--clean] [-b|--backup]'
while [[ $# > 0 ]]
  do
    key="$1"
    shift
    case $key in
      -h|--help)
      echo $HELP_TEXT
      shift
      ;;
      -d|--doc)
      ./scripts/gen_doc.sh
      shift
      ;;
      -u|--upgrade)
      ./scripts/upgrade.sh
      ./scripts/do_chmod.sh
      shift
      ;;
      -i|--install)
      ./scripts/install_dependencies.sh
      ./scripts/upgrade.sh
      ./scripts/do_chmod.sh
      shift
      ;;
      -c|--check)
      ./scripts/check_php.sh
      shift
      ;;
      -p|--permissions)
      ./scripts/do_chmod.sh
      shift
      ;;
      -r|--clear)
      echo "" | tee log/*.log
      shift
      ;;
      -b|--backup)
      ./scripts/backup.sh
      shift
      ;;
      *)
      echo $HELP_TEXT
      shift
      ;;
    esac
  done
exit 1
