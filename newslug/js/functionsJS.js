function updateTextForClipboard(format, source, location, title, subtitle, person, urn) {
	
	if(typeof String.prototype.trim !== 'function') {
	  String.prototype.trim = function() {
	    return this.replace(/^\s+|\s+$/g, '');
	  }
	}
	if (source!= "" && location != ""){
		outputStr = format + " " + source + " - " + location + " " + title;
	}else{
		outputStr = format + " " + source;
		outputStr = outputStr.trim() + " " + location;
		outputStr = outputStr.trim() + " " + title;
	}

	outputStr = outputStr.trim();
	if (subtitle != "") {
		outputStr = outputStr + " (" + subtitle + ")";
	}
	if (person != "") {
		outputStr = outputStr + " for " + person;
	}
	outputStr = outputStr + " " + urn;
	// //alert("MANA"+outputStr);
	// if (( typeof clipboardData != 'undefined') && (clipboardData.setData)) {
	// 	clipboardData.setData("text", outputStr);
	// }else{
	// 	copyStatus = window.prompt("Copy to clipboard: Ctrl+C, Enter", outputStr);
	// }
	return outputStr;
}
