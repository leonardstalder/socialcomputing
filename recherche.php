<?php


require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
require_once("models/header.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en-US" xmlns="http://www.w3.org/1999/xhtml" dir="ltr">

<body>

	<!-- header -->
	<div id="header">
		<?require_once("models/headerMenu.php");?>
	</div>
	<!-- end header -->
<!-- shell -->
<div class="shell">



<script type="text/javascript">

var index = 0;
var collection = new Array();;
var allItemsCompleted = 0;
$(init);


function reset(){

  allItemsCompleted = 0;
  $('#clothesPile2').html( '' );
  $('#clothesSlotsColum1').html( '' );
  $('#clothesSlotsColum2').html( '' );
  collection = new Array();;
  $( init );
  }
  
function displayChoices(id_brand,id_cat,id_color){
	$('#clothesPile2').html( '' );
	$.get( "http://randonnazbike.ch/social/getter.php?tbl=clothe&color="+id_color+"&categorie="+id_cat+"&seller="+id_brand, function( data ) {
	
		for ( var i=0; i<data.length; i++ ) {
			$('<div>' + '<img width="40px" src="clothes_images/'+data[i].id +'.jpg"/>' + '</div>').data('clothesId',data[i].id).attr('class', 'smallSlot').appendTo( '#clothesPile2' ).draggable( {
			stack: '#clothesPile2 div',
			containment: 'body',
			cursor: 'move',
			helper: "clone",
			revert: 'invalid'
		} );
	}
	$('#clothesPile2').append('<div style="clear:both;"></div>');
	});
	

}

function displayCanevasCompositions(){
  // Create the card slots
  for ( var i=0; i<3; i++ ) {
	
    $('<div>' + "" + '</div>').attr('class', 'smallSlot').appendTo( '#clothesSlotsColum1' ).droppable( {
      accept: '#clothesPile2 div',
      hoverClass: 'hovered',
      drop: handleClothesDrop
    } );
	}
  
}

function init() {
	displayCanevasCompositions();
}

function handleClothesDrop( event, ui ) {
	collection[allItemsCompleted] = ui.draggable.data("clothesId");
	$(this).css("border","2px solid white");
    ui.draggable.draggable( 'disable' );
	$(this).append('<img  data="'+ui.draggable.data("clothesId")+' " src="clothes_images/'+ui.draggable.data("clothesId")+'.jpg" />');
    $(this).droppable( 'disable' );
    ui.draggable.hide();
    ui.draggable.draggable( 'option', 'revert', false );
	allItemsCompleted++;
}

	
function search(){
	var category = $("#select_category").val();
	var brand = $("#select_brand").val();
	var color = $("#select_color").val();
	displayChoices(brand, category, color);
}

function searchcompos(){
	 $('#showresult').html( '' );
	if(allItemsCompleted >0){
		$.ajax({        
			type: "GET",
			url: "getter.php?tbl=searchcompo",
			data: "compositionArray="+JSON.stringify(collection),
			success: function(result) {
			
			if(result.length==0){alert("no composition available");}
		
				for ( var i=0; i<result.length; i++ ) {
				createComposition(result[i].id,result[i].slotstyle,result[i].slotpos.split(','),"#showresult",result[i].componame);
				}
							$('#showresult').append('<div  style="clear:both;"/>');

				$('[id^="clothesSelector"]').css('display','none');
			},
			error: function() {
				alert("no");        
			}
		}); 

	}else{
		alert("you havn't completed all items");
	}


}

function openmodal(id){
$('<div></div>').load('page.php?id='+id).modal({onShow: function (d) {
    // replace '0px' with your value, or remove the property
    d.container.css({ top: '70px',height: '374px'});
}}); // AJAX

}
</script>

</head>
<body>
<!-- main -->
	<div id="main">
<div id="content" >
	<div id="container" class="clothesContainer" >
	
			
		
		<div style=" padding-bottom:15px;"><img src="css/images/headerSearch.png"/></div>
	
		<div id="searchClothesContainer" style="float:left; width:185px;">
		
		<select onchange="search()" id="select_category">
			<option value="n"  selected="selected">Choose a category</option>

		<?php
		
		$mysql = new mysqli("localhost", "socialuser2", "salutsalut", "mydb") or die('There was a problem connecting to the database');
		$stmt = $mysql->prepare('Select id_categorie,categorie_name from tbl_categorie');
		$stmt->execute();
		$stmt->bind_result($id,$nom);
		while($row = $stmt->fetch()){
			echo '<option value="'.$id.'">'.$nom.'</option>';
		}
		?>
		</select>
		<select onchange="search()" id="select_brand">
			<option value="n"  selected="selected">Choose a brand</option>
		<?php
		
		$mysql = new mysqli("localhost", "socialuser2", "salutsalut", "mydb") or die('There was a problem connecting to the database');
		$stmt = $mysql->prepare('Select id_seller,seller_name from tbl_seller');
		$stmt->execute();
		$stmt->bind_result($id,$nom);
		while($row = $stmt->fetch()){
			echo '<option value="'.$id.'">'.$nom.'</option>';
		}
		?>
		</select></br>
		<select  onchange="search()" id="select_color">
			<option value="n"  selected="selected">Choose a color</option>
		<?php
		
		$mysql = new mysqli("localhost", "socialuser2", "salutsalut", "mydb") or die('There was a problem connecting to the database');
		$stmt = $mysql->prepare('Select id_color,color_name from tbl_color');
		$stmt->execute();
		$stmt->bind_result($id,$nom);
		while($row = $stmt->fetch()){
			echo '<option value="'.$id.'">'.$nom.'</option>';
		}
		?>
		</select></br>
		
		
		</div>
		
		<div id="clothesPile2"  style="float:left;overflow:auto; height:110px; width:330px; border: 1px solid black;"  class="shadow">
		</div>
		
		<div id="clothesComposition" style="float:left; padding-left:10px;">
		
			<div id="clothesSlots" style="float:left; background-color:white;height:110px;width:230px"  class="shadow">
				<div id="clothesSlotsColum1" class="clothesSlotsColum" style="width:240px;">
				</div>
			</div>
			
		</div>
		
		<div style="float:left; width:120px; padding-left:10px;">
			<button onclick="searchcompos()" >Search compositions</button>
			<button onclick="reset()">Reset the search</button>
		</div>

		<div  style="clear:both;"/>
		<div style="padding-top:50px;"></div>

		<div id="showresult" ></div>
	</div>
	
	
</div>


	</div>	
	</div>
	<!-- end main -->
	
	<!-- footer -->
	<div id="footer">
		<?require_once("models/footer.php");?>
	</div>
	<!-- end footer -->

</div>
<!-- end shell -->
</body>
</html>

