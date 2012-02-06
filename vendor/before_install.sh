#!/bin/sh

wget http://pecl.php.net/get/pecl_http-1.7.1.tgz
tar -zxf pecl_http-1.7.1.tgz
sh -c "cd pecl_http-1.7.1 && phpize && ./configure --enable-http && make && sudo make install"
echo "extension=http.so" >> `php --ini | grep "Loaded Configuration" | sed -e "s|.*:\s*||"`
