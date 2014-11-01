<?php


require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
require_once("models/header.php");

?>
<script>

var sizes = [[ 0,3,'longSlotMini', 'bigSlotMini','smallSlotMini', 'smallSlotMini','bigSlotMini'],
			 [ 1,3,'bigSlotMini', 'longSlotMini','smallSlotMini', 'smallSlotMini','bigSlotMini'],
			 [ 2,3,'bigSlotMini', 'longSlotMini','longSlotMini', 'bigSlotMini'] ];

$( document ).ready(function() {
  createComposition(2,2,[11,12,13,14]);
   createComposition(1,1,[11,22,13,14,20]);
      createComposition(22,1,[11,22,13,14,20]);
	     createComposition(12,1,[11,22,13,14,20]);
		    createComposition(13,1,[11,22,13,14,20]);
			   createComposition(14,1,[11,22,13,14,20]);
			      createComposition(15,1,[11,22,13,14,20]);
	$('#content').append('<div style="clear:both"></div>');
});	

function createComposition(id,slotstyle,collection){

	$('#content').append('<div class="user-box"><div style="width:200px; height:200px; padding-top:14px; padding-left:10px;" id="clothesSlots'+id+'">' +
		'<div id="clothesSlotsColum1'+id+'" class="clothesSlotsColumMini"></div>' +
		'<div id="clothesSlotsColum2'+id+'" class="clothesSlotsColumMini"></div>' +
	  '</div></div>');
	
  // Create the card slots
  for ( var i=2; i<sizes[slotstyle].length; i++ ) {
	if(i<=sizes[slotstyle][1]){
		$('#clothesSlotsColum1'+id ).append('<div class="'+sizes[slotstyle][i]+'"><img  src="clothes_images/'+collection[i-2]+'.jpg" />' + '</div>');
	}else
	{
		$('#clothesSlotsColum2'+id ).append('<div class="'+sizes[slotstyle][i]+'"><img  src="clothes_images/'+collection[i-2]+'.jpg" />' + '</div>');
	}
  }
}


</script>
<body>

	<!-- header -->
	<div id="header">
		<?require_once("models/headerMenu.php");?>
	</div>
	<!-- end header -->
	
	<!-- shell -->
	<div class="shell">
		<div id="main" >
			<div id="content" class="clothesContainer">
			
			
			
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