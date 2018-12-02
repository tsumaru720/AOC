FROM php:7.2-cli

RUN apt-get update \
    && apt-get -y install pypy

ADD entrypoint.sh /entrypoint.sh
ADD runBoth.sh /runBoth.sh
RUN chmod +x /entrypoint.sh /runBoth.sh

USER nobody

CMD /entrypoint.sh
VOLUME /code
