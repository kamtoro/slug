function updateTextForClipboard(format, source, location, title, subtitle, person, urn) {	
	if(typeof String.prototype.trim !== 'function') {
	  String.prototype.trim = function() {
	    return this.replace(/^\s+|\s+$/g, '');
	  }
	}
	if (source!= "" && location != ""){
		outputStr = urn + " " + source + " " + location + " - " + title;
	}else{
		if (source== ""){
			outputStr = urn + " " + location;
		}else{
			outputStr = urn + " " + source;
		}
	}
	outputStr = outputStr.trim() + " - " + title;
	outputStr = outputStr.trim();
	if (subtitle != "") {
		outputStr = outputStr + " (" + subtitle + ")";
	}
	if (person != "") {
		outputStr = outputStr + " for " + person;
	}
	return outputStr;
}
