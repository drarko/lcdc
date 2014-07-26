<?php

namespace Annotations;

/** @Annotation */
class Color extends CustomAnnotation 
{
     public $type = "Color";

     public function renderList($data) 
     {
	return '<span style="background-color:'. $data .'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>';
     }
     
     public function renderForm($data, $property) 
     {
	return '<input type="text" name="' . $property . '" value="'. $data .'"></input><div id="colorpickerHolder"></div>
		<script>$("#colorpickerHolder").ColorPicker({
		  ' . ($data != "" ? 'color: "'. $data .'",' : '') . '
		  flat: true,
		  onChange: function() {
		    var color = $(".colorpicker_hex > input").first().val()
		    $("input[name=' . $property . ']").val("#"+color);
		  }
		});</script>';
     }     
}