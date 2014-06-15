if(restitle == "") {
	document.write('<span><i class="icon"></i><i><a href="#" thunderHref="' + ThunderEncode(thunder_url) + '" thunderPid="' + thunder_pid + '" thunderType="' + thunder_type + '" thunderResTitle="' + restitle + '" onClick="return OnDownloadClick_Simple(this, 2)" oncontextmenu="ThunderNetwork_SetHref(this)" class="aThunder">я╦ювобть</a></i></span>');
}
else {
	document.write('<span><i class="icon"></i><i><a href="#" thunderHref="' + ThunderEncode(thunder_url) + '" thunderPid="' + thunder_pid + '" thunderType="' + thunder_type + '" thunderResTitle="' + restitle + '" onClick="return OnDownloadClick_Simple(this, 2)" oncontextmenu="ThunderNetwork_SetHref(this)" class="aThunder">' + restitle + '</a></i></span>');
}