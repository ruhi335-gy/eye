#!/bin/bash
# banner2() uses color vars defined in evel.sh.
# This file must only be sourced via load_lib() — not run standalone —
# unless colors are pre-defined.

# Version
version="0.2"

small_banner() {
    echo -e "${cyan}"
    echo "███████╗██╗   ██╗███████╗"
    echo "██╔════╝╚██╗ ██╔╝██╔════╝"
    echo "█████╗   ╚████╔╝ █████╗  "
    echo "██╔══╝    ╚██╔╝  ██╔══╝  "
    echo "███████╗   ██║   ███████╗"
    echo "╚══════╝   ╚═╝   ╚══════╝"
    echo -e "${nocolor}"
}

# banner
banner() {
    echo -e "${cyan}"
    echo "███████╗██╗   ██╗███████╗"
    echo "██╔════╝╚██╗ ██╔╝██╔════╝"
    echo "█████╗   ╚████╔╝ █████╗  "
    echo "██╔══╝    ╚██╔╝  ██╔══╝  "
    echo "███████╗   ██║   ███████╗"
    echo "╚══════╝   ╚═╝   ╚══════╝"
    echo -e "${nocolor}"
}

# banner2
banner2() {
    echo -e "${green}    Camera Phisher by ${redbg}${white}gk_tool.${nocolor}${white}"
    echo -e "${white}    OS-Detect: ${red}$DISTRO"
    echo -e "${white}    Version: $version ${nocolor}"
}

show_banner() {
    if [[ "$OS_NAME" == "Android" ]]; then
        small_banner
    else
        banner | lolcat
    fi
}