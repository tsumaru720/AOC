FROM alpine:3.8

RUN apk add --no-cache php7 bash python

ADD entrypoint.sh /entrypoint.sh
ADD runBoth.sh /runBoth.sh
RUN chmod +x /entrypoint.sh /runBoth.sh

USER nobody

CMD /entrypoint.sh
VOLUME /code
