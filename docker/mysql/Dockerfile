FROM mysql:5.7

RUN  sed -i '/client\]/a  max_allowed_packet = 300M ' /etc/mysql/my.cnf
RUN  sed -i '/mysqld\]/a   \
event_scheduler=ON   \n\
default-storage-engine=INNODB   \n\
#default-character-set=utf8    \n\
character-set-server = utf8    \n\
max_allowed_packet = 300M    \n\
wait_timeout	= 500    \n\
interactive_timeout	= 500    \n\
connect_timeout = 500    \n\

' /etc/mysql/my.cnf

