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

var sizes = [[ 0,3,'longSlot', 'bigSlot','smallSlot', 'smallSlot','bigSlot'],
			 [ 1,3,'bigSlot', 'longSlot','smallSlot', 'smallSlot','bigSlot'],
			 [ 2,3,'bigSlot', 'longSlot','longSlot', 'bigSlot'] ];
var index = 0;
var collection = new Array();;
var allItemsCompleted = 0;
$(init);

function navigate(nav){
	index = index + nav;
	if(index == sizes.length)
		index = 0;
	if(index <0)
		index = sizes.length -1 ;
	reset();
	displayChoices();
	displayCanevasCompositions();
}

function reset(){
  allItemsCompleted = 0;
  $('#clothesPile').html( '' );
  $('#clothesSlotsColum1').html( '' );
  $('#clothesSlotsColum2').html( '' );
  collection = new Array();;
  $( init );
  }
  
function displayChoices(id_brand,id_cat,id_color){
	$('#clothesPile').html( '' );
	$.get( "http://randonnazbike.ch/social/getter.php?tbl=clothe&color="+id_color+"&categorie="+id_cat+"&seller="+id_brand, function( data ) {
		for ( var i=0; i<data.length; i++ ) {
			$('<div>' + '<img width="40px" src="clothes_images/'+data[i].id +'.jpg"/>' + '</div>').data('clothesId',data[i].id).attr('class', 'smallSlot').appendTo( '#clothesPile' ).draggable( {
			stack: '#clothesPile div',
			cursor: 'move',
			container: 'body',
			helper: 'clone',
			revert: true
		} );
	}
	$('#clothesPile').append('<div style="clear:both;"></div>');
	});
	

}

function displayCanevasCompositions(){
  // Create the card slots
  for ( var i=2; i<=sizes[index].length; i++ ) {
	if(i<=sizes[index][1]){
    $('<div>' + "" + '</div>').attr('class', sizes[index][i]).appendTo( '#clothesSlotsColum1' ).droppable( {
      accept: '#clothesPile div',
      hoverClass: 'hovered',
      drop: handleClothesDrop
    } );
	}else
	{
	 $('<div>' + "" + '</div>').attr('class', sizes[index][i]).appendTo( '#clothesSlotsColum2' ).droppable( {
      accept: '#clothesPile div',
      hoverClass: 'hovered',
      drop: handleClothesDrop
	} );
	}
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

function create(){
	if(allItemsCompleted == (sizes[index].length-2)){
		$.ajax({        
			type: "GET",
			url: "getter.php?tbl=addcompo",
			data: "compositionArray="+JSON.stringify(collection)+"&compoCanevas="+index+"&compoName="+$('#compositionName').val()+"&catStyle="+$('#select_style').val(),
			success: function(result) {
				$('<div></div>').load('pageConfirm.php?id='+result).modal();
				reset();
				 
				
			},
			error: function() {
				alert("Error, you do not complete all items");        
			}
		}); 

	}else{
		alert("you havn't completed all items");
	}
	
	
}

</script>

</head>
<body>

<!-- main -->
	<div id="main">
<div id="content" >
	<div id="container" class="clothesContainer" >
		<div id="clothesComposition" style="float:left; width:480px;">
			<div style="padding-top:15px; padding-bottom:15px;"><h2>1. Choose your canevas...</h2></div>
			<div id="left" style="float:left; padding-top:120px; width:70px;">
				<span onclick="navigate(-1)" id="button-previous"></span>
			</div>
			<div id="clothesSlots" style="float:left; background-color:white"  class="shadow">
				<div id="clothesSlotsColum1" class="clothesSlotsColum">
				</div>
				<div id="clothesSlotsColum2" class="clothesSlotsColum">
				</div>
			</div>
			<div id="right" style="padding-top:120px; float:left; width:100px;">
				<span onclick="navigate(1)" id="button-next"></span>
			</div>
		</div>
		<div id="nameContainer" style="float:left; width:320px;">
		<div style="padding-top:15px; padding-bottom:15px;"><h2>2. Give a description...</h2></div>
		<input type="text" id="compositionName" placeholder="Composition title">
		</br>
		<select id="select_style">
			<option value="" disabled="disabled" selected="selected">Choose a category</option>

		<?php
		
		$mysql = new mysqli("localhost", "socialuser2", "salutsalut", "mydb") or die('There was a problem connecting to the database');
		$stmt = $mysql->prepare('Select id_style,style_name from tbl_style');
		$stmt->execute();
		$stmt->bind_result($id,$nom);
		while($row = $stmt->fetch()){
			echo '<option value="'.$id.'">'.$nom.'</option>';
		}
		?>
		</select></br></br>
		</div>
		<div id="searchClothesContainer" style="float:left; width:300px;">
		<div style="padding-top:15px; padding-bottom:15px;"><h2>3. Search your clothes...</h2></div>
		
		<select id="select_category">
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
		<select id="select_brand">
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
		<select id="select_color">
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
		<button onclick="search()">Search</button>
		</div>
		<div style="clear:both;"/>
		<div id="clothesSelector"  >
			<div style="padding-top:15px; padding-bottom:15px;"><h2>4. Drag your favorites clothes and make your composition</h2></div>
			<div id="clothesPile" style="overflow: auto; height:300px;" class="shadow">
			</div>
			<button onclick="reset()">Reset</button>
			<button onclick="create()">Create</button>
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

