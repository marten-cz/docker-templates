# Start with a Python image.
FROM python:2.7.14-stretch

# Some stuff that everyone has been copy-pasting
# since the dawn of time.
ENV PYTHONUNBUFFERED 1

# Install some necessary things.
RUN apt-get update
RUN apt-get install -y swig libssl-dev dpkg-dev netcat

# Install our requirements.
RUN pip install -U pip

# Install additional packages
#RUN apt-get install -y .....

# Copy all our files into the image.
RUN mkdir /usr/src/app
WORKDIR /usr/src/app
COPY ./ /usr/src/app/

RUN pip install -Ur requirements.txt

# Collect our static media files
RUN python ./manage.py collectstatic --noinput

RUN apt-get clean

# Specify the command to run when the image is run.
CMD ["./prod_run.sh"]
