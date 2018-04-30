/*add this on the css part

.c0{background-color:#F44336;!important}
.c1{background-color:#76FF03;!important}
.c2{background-color:#9C27B0;!important}
.c3{background-color:#FFEB3B;!important}
.c4{background-color:#3F51B5;!important}
.c5{background-color:#FFAB91;!important}
.c6{background-color:#03A9F4;!important}
.c7{background-color:#4CAF50;!important}
.c8{background-color:#009688;!important}
.c9{background-color:#E65100;!important}


*/



var textArray = [["Corporate Information","公司資訊"],
["Information about Skymark Airlines Inc.","Skymark Airlines Inc.相關資訊"],
["Corporate Profile","企業簡介"],
["An overview of Skymark Airlines Inc.","Skymark Airlines Inc.概要"],
["Messages from CEO and Chairman","執行長與主席致辭"],
["About Us","公司簡介"],
["List of officers","主管名單"],
["New Skymark Policies","Skymark全新政策"],
["History of Corporate Activity","公司活動歷程記錄"],
["IR","IR"],
["Information for stockholders and investors.","股東與投資者相關資訊。"],
["Disclaimer","免責聲明"]];

var colorArray = ["#F44336","#76FF03","#9C27B0","#FFEB3B","#3F51B5","#FFAB91","#03A9F4","#4CAF50","#009688","#E65100"];
var htmlLang = "en";
var lang = 0;
var htmlTreeArray = [];
var textNotFoundArray = [];

function getElementsWithText(){
	var a = [];
	$("main *").each(function(){
		if($(this).children().length==0){
			a.push(this);
		}
	});
	return a;
}

htmlTreeArray = getElementsWithText();



htmlLang = $("html")[0].lang;
if(htmlLang == "en"){
	lang = 0;
}
else{
	lang = 1;
}

//console.log(htmlTreeArray);

textArray.forEach(function(e,tIndex){
	var t = e[lang];
	var lock = false;
	var pinnedIndex = 0;
	for(var i = 0; i<htmlTreeArray.length; i++){
		if(t==$(htmlTreeArray[i])[0].innerText){
			$(htmlTreeArray[i]).addClass("c"+tIndex%10);
			htmlTreeArray.splice(i,1);
			break;
		}
		if((i+1)==htmlTreeArray.length){
			textNotFoundArray.push(t);	
		}
	}
});



console.log("hindi nakita");
console.log(textNotFoundArray);


