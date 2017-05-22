### Run script over SSH
ssh -o CheckHostIP=no \
    -o IdentitiesOnly=yes \
    -o StrictHostKeyChecking=no \
    -o PasswordAuthentication=no \
    -o IdentityFile={{ server_private_key }} \
    -p {{ server_port }} {{ server_username }}@{{ server_ip_address }} 'DEBIAN_FRONTEND=noninteractive bash -s' << 'EOF'
        # Turn on quit on non-zero exit
        set -e
        {{ script }}
EOF
