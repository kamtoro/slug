function updateTextForClipboard(format, source, location, title, subtitle, person, urn) {
	
	if(typeof String.prototype.trim !== 'function') {
	  String.prototype.trim = function() {
	    return this.replace(/^\s+|\s+$/g, '');
	  }
	}
	if (source!= "" && location != ""){
		outputStr = urn + " " + location + " " + source + " - " + title;
	}else{
		if (source== ""){
			outputStr = urn + " " + location;
		}else{
			outputStr = urn + " " + source;
		}
		outputStr = outputStr.trim() + " - " + title;
	}

	outputStr = outputStr.trim();
	if (subtitle != "") {
		outputStr = outputStr + " (" + subtitle + ")";
	}
	if (person != "") {
		outputStr = outputStr + " for " + person;
	}
	return outputStr;

	// The below Is how the recording used to be copied before changes requested
	// The below Is how the recording used to be copied before changes requested
	// 	if(typeof String.prototype.trim !== 'function') {
	//   String.prototype.trim = function() {
	//     return this.replace(/^\s+|\s+$/g, '');
	//   }
	// }
	// if (source!= "" && location != ""){
	// 	outputStr = format + " " + source + " - " + location + " " + title;
	// }else{
	// 	outputStr = format + " " + source;
	// 	outputStr = outputStr.trim() + " " + location;
	// 	outputStr = outputStr.trim() + " " + title;
	// }

	// outputStr = outputStr.trim();
	// if (subtitle != "") {
	// 	outputStr = outputStr + " (" + subtitle + ")";
	// }
	// if (person != "") {
	// 	outputStr = outputStr + " for " + person;
	// }
	// outputStr = outputStr + " " + urn;
	// return outputStr;
}
