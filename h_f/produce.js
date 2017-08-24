var h_f_list = new Array();

h_f_config.forEach(function(value){
	if ( "favo" in value ){
		if( value["favo"] == "" ){
			value["favo"] = "http://" + value["url"] + "/favicon.ico";
		}
	} else {
		value["favo"] = "http://" + value["url"] + "/favicon.ico";
	}

	if ( "haiiro" in value ){
		var haiiro = 'class="haiiro"';
		value["favo"] = "https://9yu.github.io/public/h_f/jichen.png"
	} else {
		var haiiro = "";
	}

	if ( "mark" in value ) {
		var mark_s = '<span class="h_mark">' + value["mark"];
		var mark_e = '</span>';
	} else {
		var mark_s = '';
		var mark_e = '';
	}

	var h_f_list_index = "" + value["naka"] + Math.floor(Math.random() * (9999 - 1000) + 1000);;
	h_f_list[h_f_list_index] = '<li '+ haiiro +'><img src="' + value["favo"] + '" onerror="this.src=\'https://9yu.github.io/public/h_f/xiaopo.png\';this.className=\'lite\'"><div>' + mark_s + '<span>' + value["name"] + '</span>' + mark_e + '<a href="http://' + value["url"] + '" target="_h_f">' + value["url"] + '</a></div></li>';
});

function pr_hf(){
	for (var i = 100000 ; i >= 0; i--) {
		if( i in h_f_list ){
			$('#h_f').append(h_f_list[i]);
		}
	}
};