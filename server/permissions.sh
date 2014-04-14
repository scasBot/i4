cd ~/web/i4

# all folders should not be globally accessible
chmod 700 ajax/
chmod 700 data/
chmod 700 server/
chmod 700 templates/
chmod 700 models/

# everything inside of these should only be called from html
chmod 700 ajax/*
chmod 700 data/*
chmod 700 server/*
chmod 700 templates/*
chmod 700 models/*

# html is publicly accessible, not readable
chmod 711 html/ 
chmod 711 html/*.php
chmod 711 html/fonts/

# configuration file for api
chmod 711 html/api/*.php
chmod 700 html/api/api_includes/
chmod 700 html/api/api_includes/*.php

# all these directories publicly accessible, not readable
chmod 711 html/js/
chmod 711 html/css/
chmod 711 html/img/
chmod 711 html/api/
chmod 711 html/resources/

# these files are globally readable
chmod 644 html/js/*.js
chmod 644 html/css/*.css
chmod 644 html/img/*
chmod 644 html/resources/*
chmod 644 html/fonts/*
