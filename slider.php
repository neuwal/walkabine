<table class="wahlcheck-slider">
<tr>

<?php
	for($j=1; $j<=15; $j++) { 
?>

<td width="5%" <?php if($j==$question) { ?>class="bg-efefef"<?php } ?>><a href="<?= $j ?>.php" class="text-decoration-none black"><?= $j ?></a></td>

<?php
	}
?>

</tr>
</table>