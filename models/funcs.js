var miniSizes = [[ 0,3,'longSlotMini', 'bigSlotMini','smallSlotMini', 'smallSlotMini','bigSlotMini'],
			 [ 1,3,'bigSlotMini', 'longSlotMini','smallSlotMini', 'smallSlotMini','bigSlotMini'],
			 [ 2,3,'bigSlotMini', 'longSlotMini','longSlotMini', 'bigSlotMini'] ];

var sizes = [[ 0,3,'longSlot', 'bigSlot','smallSlot', 'smallSlot','bigSlot'],
			 [ 1,3,'bigSlot', 'longSlot','smallSlot', 'smallSlot','bigSlot'],
			 [ 2,3,'bigSlot', 'longSlot','longSlot', 'bigSlot'] ];			 
function showHide(div){
	if(document.getElementById(div).style.display = 'block'){
		document.getElementById(div).style.display = 'none';
	}else{
		document.getElementById(div).style.display = 'block'; 
	}
}


function createComposition(id,slotstyle,collection,mainContainer,compositionName){

	$(mainContainer).append('<div onclick="openmodal('+id+');" style="cursor:pointer;" class="user-box"><div style="width:180px; height:180px; padding-top:11px; padding-left:7px;" id="clothesSlots'+id+'">' +
		'<div id="clothesSlotsColum1'+id+'" class="clothesSlotsColumMini"></div>' +
		'<div id="clothesSlotsColum2'+id+'" class="clothesSlotsColumMini"></div>' +
	  '</div><div style="margin-top:-35px; word-wrap: break-word; width: 165px;text-align:center" >'+compositionName.substring(0,60)+'</div></div>');
	
  // Create the card slots
  for ( var i=2; i<miniSizes[slotstyle].length; i++ ) {
	if(i<=miniSizes[slotstyle][1]){
		$('#clothesSlotsColum1'+id ).append('<div class="'+miniSizes[slotstyle][i]+'"><img  src="clothes_images/'+collection[i-2]+'.jpg" />' + '</div>');
	}else
	{
		$('#clothesSlotsColum2'+id ).append('<div class="'+miniSizes[slotstyle][i]+'"><img  src="clothes_images/'+collection[i-2]+'.jpg" />' + '</div>');
	}
  }
}
function incrementLike(id){
	$.ajax({        
			type: "GET",
			url: "getter.php?tbl=rating&id="+id,
			success: function(result) {
				document.getElementById("nboflikes"+id).innerHTML=(parseInt(document.getElementById("nboflikes"+id).innerHTML)+1);
				document.getElementById('likebutton'+id).disabled = true;
				$('[id^="likebutton'+id+'"]').css('color','gray');
				$('[id^="likebutton'+id+'"]').css('font-weight','100');
				$('[id^="nboflikes'+id+'"]').css('color','black');
				$('[id^="nboflikesword'+id+'"]').css('color','black');
			},
			error: function() {
				alert("no");        
			}
		}); 
}
function loadPage(id,ids)
{
	
	if($('#dettext'+id).html()=="Hide clothes informations"){
	$('#details'+id).css('visibility','hidden');
	$('#dettext'+id).html("Show clothes informations");
	return;
	}
	
	console.log(ids);
	$('#details'+id).css('visibility','visible');
	$('#details'+id).css('position','relative');
	$('#details'+id).css('z-index','999');
	$('#details'+id).css('background-color','#efefef');
	
	$('#dettext'+id).html("Hide clothes informations");
	$.ajax({
		type: "GET",
		url: "page_details.php",
		data: 'id='+ids,
		dataType: "html",
		success: function(msg){
			
			if(msg.length>10)
			{
				$('#loading'+id).css('visibility','hidden');
				$('#details'+id).html(msg);
				
			}
		}
		
	});

}
function createBigComposition(id,slotstyle,collection,mainContainer,rating,buttonEnabled,compositionName,username,userid){

var gg=collection.join();

var buttonLike='<button style="color:#305E86; font-weight: bold;"  id="likebutton'+id+'" onclick="incrementLike('+id+')" >Like </button>'+'&nbsp'+'<span style="align:center"><span id="nboflikes'+id+'">'+rating+'</span> <span id="nboflikesword'+id+'"> likes</span><span style="float:right; padding-top:10px; padding-right:5px;">'+compositionName.substring(0,100)+' by '+'<a href="profileUser.php?id='+userid+'">'+username+'</a></span></span>';

if(buttonEnabled==0){buttonLike ='<button style="color:gray; font-weight:100;" disabled id="likebutton'+id+'" onclick="incrementLike('+id+')" >Like </button>'+'&nbsp'+'<span style="align:center"><span id="nboflikes'+id+'" style ="color:black;">'+rating+'</span> <span id="nboflikesword'+id+'"  style ="color:black;" > likes</span><span style="float:right; padding-top:10px; padding-right:5px;">'+compositionName.substring(0,100)+' by '+'<a href="profileUser.php?id='+userid+'">'+username+'</a></span></span>';}

$(mainContainer).append('<div  style="position:relative; min-height: 374px;" class="shadow">'+
					'<div style=" width: 308px;  margin-left: auto; margin-right:auto;">'+
						'<div style="float:left; width:308px;">'+
							'<div id="clothesSlots" style=" background-color:white" >'+
								'<div id="clothesSlotsColum1Big'+id+'" class="clothesSlotsColum">'+
								'</div>'+
								'<div id="clothesSlotsColum2Big'+id+'" class="clothesSlotsColum">'+
								'</div>'+
							'</div>'+'<div style="border: solid 1px black;">'+
							'<div style="width:306px; height:35px;  background-color:#efefef;">'+
								buttonLike+
							
					'</div>'+
					'<div style=" text-align:center;font-weight:bold;width:306px; height:35px;  background-color:#efefef;" ><a style="margin:10px; padding-top:5px;" id="dettext'+id+'" onclick="loadPage('+id+",'"+gg+"'"+')">Show clothes informations</a>'+
						'<div style="visibility:hidden;" align="center" id="details'+id+'"><img id="loading'+id+'" src="models/ajax_load.gif" alt="loading" /></div></div></div></div>'+
					'</div> '+
				'</div>');
				
	 // Create the card slots
	 console.log("slotstyle : " + slotstyle );
  for ( var i=2; i<sizes[slotstyle].length; i++ ) {
	if(i<=sizes[slotstyle][1]){
		$('#clothesSlotsColum1Big'+id ).append('<div style="border:1px solid white;" class="'+sizes[slotstyle][i]+'"><img  src="clothes_images/'+collection[i-2]+'.jpg" />' + '</div>');
	}else
	{
		$('#clothesSlotsColum2Big'+id ).append('<div style="border:1px solid white;" class="'+sizes[slotstyle][i]+'"><img  src="clothes_images/'+collection[i-2]+'.jpg" />' + '</div>');
	}
  }

}


function createBigCompositionConfirm(id,slotstyle,collection,mainContainer,rating,buttonEnabled,compositionName,username,userid){



$(mainContainer).append('<div  style="position:relative; min-height: 400px;">'+
					'<div style="width:306px; height:60px; color:black; text-align:center; background-color:#efefef;"><h2>Your combination was created successfully</h2></div>'+
					'<div style=" width: 308px;  margin-left: auto; margin-right:auto;">'+
						'<div style="float:left; width:308px;">'+
							'<div id="clothesSlots" style=" background-color:white" >'+
								'<div id="clothesSlotsColum1Big'+id+'" class="clothesSlotsColum">'+
								'</div>'+
								'<div id="clothesSlotsColum2Big'+id+'" class="clothesSlotsColum">'+
								'</div>'+
							'</div></div></div>'+
					'</div> '+
				'</div>');
				
	 // Create the card slots
	 console.log("slotstyle : " + slotstyle );
  for ( var i=2; i<sizes[slotstyle].length; i++ ) {
	if(i<=sizes[slotstyle][1]){
		$('#clothesSlotsColum1Big'+id ).append('<div style="border:1px solid white;" class="'+sizes[slotstyle][i]+'"><img  src="clothes_images/'+collection[i-2]+'.jpg" />' + '</div>');
	}else
	{
		$('#clothesSlotsColum2Big'+id ).append('<div style="border:1px solid white;" class="'+sizes[slotstyle][i]+'"><img  src="clothes_images/'+collection[i-2]+'.jpg" />' + '</div>');
	}
  }

}