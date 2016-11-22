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

//add a function to jQuery so we can call it on our jQuery collections
$.fn.capitalize = function () {

    //iterate through each of the elements passed in, `$.each()` is faster than `.each()
    $.each(this, function () {

        //split the value of this input by the spaces
        var split = this.value.split(' ');

        //iterate through each of the "words" and capitalize them
        for (var i = 0, len = split.length; i < len; i++) {
            split[i] = split[i].charAt(0).toUpperCase() + split[i].slice(1);
        }

        //re-join the string and set the value of the element
        this.value = split.join(' ');
    });
    return this;
};

