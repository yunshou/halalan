function toggle_details() {
	/*
		<tr> parent
		<td> parent
		<img /> this
		</td>
		</tr>
		<tr> next
		<td> children(0)
		<div></div> children(0)
		</td>
		</tr>
	*/
	$(this).parents("tr").next().find("div.details").slideToggle('normal');
	return false;
}

$(document).ready(function() {
	/* Bind handlers to events */
	$("a.toggle_details").click(toggle_details);
});