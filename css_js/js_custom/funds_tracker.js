$(document).unbind("keydown").bind("keydown",function(e){
	var vPreventDefault=false;
	var vElement = e.srcElement||e.target;
	if((vElement.tagName.toUpperCase()==="INPUT" &&
		(vElement.type.toUpperCase()==="TEXT"
			|| vElement.type.toUpperCase()==="PASSWORD" || vElement.type.toUpperCase()==="FILE"
			|| vElement.type.toUpperCase()==="SEARCH" || vElement.type.toUpperCase()==="EMAIL"
			|| vElement.type.toUpperCase()==="NUMBER"||vElement.type.toUpperCase()==="DATE"))	||vElement.tagName.toUpperCase()==="TEXTAREA")
	{
		vPreventDefault=vElement.readOnly||vElement.disabled;
	}
	else{
		vPreventDefault=true;
	}
	if(e.keyCode===8){
		if(vPreventDefault){
			e.preventDefault();
		}
	}
	else{
		if(!e.ctrlKey&&!e.altKey&&vPreventDefault){ //our busy loop condition should come here &&!($("#mainprocessmessage").is(":visible")||$("#lookupprocessmessage").is(":visible"))
			var vKeyPath = glbShrtcuts.getKeyPath(e.keyCode);
			if(vKeyPath && vKeyPath != location.pathname){
				//location.href=glbShrtcuts.getKeyPath(e.keyCode);
			}
		}
	}
});

var glbShrtcuts=(function(){
	var vKeyMap={};
	return Object.freeze({
		addNewKey:function(vKeyCode,vUrl){
			if(vKeyCode&&vUrl){
				vKeyMap[vKeyCode]=vUrl;
				return true;
			}else{
				return false;
			}
		},
		removeKey:function(vKeyCode){
			if(vKeyCode){
				return delete vKeyMap[vKeyCode];
			}
			else{
				return false;
			}
		},
		getKeyPath:function(vKeyCode){
			return vKeyMap[vKeyCode];
		}
	});
})();

$(function(){
	glbShrtcuts.addNewKey(66,"/funds_tracker/bank_account/bank_book_summary");
	glbShrtcuts.addNewKey(67,"/funds_tracker/cheque_book");
	glbShrtcuts.addNewKey(73,"/funds_tracker/instrument_type");
	glbShrtcuts.addNewKey(80,"/funds_tracker/party");
	glbShrtcuts.addNewKey(82,"/funds_tracker/report/party");
});
