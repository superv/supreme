### Send file to server - {{ deployment }}
rsync -ave \
    "ssh -p {{ server_port }} \
         -o CheckHostIP=no \
         -o IdentitiesOnly=yes \
         -o StrictHostKeyChecking=no \
         -o PasswordAuthentication=no \
         -o IdentityFile={{ server_private_key }}" \
             --rsync-path='mkdir -p {{ remote_file }} && rsync' \
             --delete  \
    {{ local_file }} {{ server_username }}@{{ server_ip_address }}:{{ remote_file }}
