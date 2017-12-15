<div class="row body">
	<div style="padding-left:25px;" class="row body">
		<div class="col-md-6">
			<h3> Profil de <?php echo ''.$user->get('login').'' ?> </h3>
			<?php
				echo'
				<p class="row">Pseudo : '.$user->get('login').' </p>
				<p class="row">Quartier : '.$quartier->get('nomQuartier').'</p>
				<p class="row">Note :'; if($user->get('niveau') != null){echo '<img class="etoileP" src="./lib/image/'.$user->get('niveau').'_etoiles.png">'; }else{echo ' Non noté ';}
			?>
		</div>

	</div>
</div>
