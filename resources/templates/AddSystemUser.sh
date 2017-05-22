if id -u {{ user }}; then
    echo "Username {{ user }} already exists" >&2
    exit 1
fi
useradd {{ user }} -d "/home/{{ user }}" -m
echo "{{ user }}:{{ password }}" | chpasswd