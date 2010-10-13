<?php /* #?ini charset="utf-8"?

[AdserverSettings]

AdserverURL=http://openx.xrow.de/www
#Points to the www directory of OpenX

SiteID=2
# Get this ID from http://openx.xrow.de/www/delivery/spcjs.php?id=2
# It is the ID of the Website you setup in Openx(OpenX Admin -> Inventory -> Websites). 

BannerZones[]
BannerZones[banner_120x90]=8
BannerZones[banner_120x60]=9
BannerZones[banner_468x60]=5
BannerZones[banner_234x60]=10
BannerZones[banner_336x280]=7
BannerZones[banner_728x90]=2
BannerZones[banner_300x250]=3
BannerZones[banner_88x31]=11
BannerZones[banner_180x150]=12
BannerZones[banner_120x600]=6
BannerZones[banner_125x125]=13
BannerZones[banner_250x250)=14
BannerZones[banner_120x240]=15
BannerZones[banner_240x400]=16
BannerZones[banner_160x600]=4
# BannerZones[KEY]=OpenX Zone ID

# The ads will get implemented on the Website wiht the following JS code.
# <script type='text/javascript'><!--// <![CDATA[
# OA_show('Leaderboard_728x90');
# // ]]> --></script>
#
# or use the template operator
#
# {openx_show('Leaderboard_728x90')}

*/ ?>