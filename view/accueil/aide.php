<div class="row body">
	<div class="col-md-12">	
		<div class="row">
			<div class="col-md-2" style="text-align:center;">
				<h1> Aide </h1>
			</div> 
				<?php if(isset($_SESSION['login'])){
				echo	'
			<a  href="./index.php?controller=accueil&action=requete" type="button" class="btn btn-default" style="margin-top:20px;margin-bottom:10px;"> Contacter un modérateur</button> </a>';} ?>
			</div>
		<div class="row video">
			<div>
				<iframe  width="560" height="315" src="https://www.youtube.com/embed/wOnE5-vtRus" frameborder="0" allowfullscreen></iframe>
			</div>
		</div>
		<div class="row aide2">
			<div class="col-xs-offset-1 col-xs-4 aide">
				<h2> J’EMPRUNTE </h2>
				<h3> 1- Demande </h3>
				<p>- Je cherche l’objet dont j’ai besoin.</p>
				<p>- Une fois l’objet trouvé, je fais une demande de prêt qui devra être
				validée par l’administrateur du site et par le prêteur.</p>
				<p>- Une fois validée, je peux contacter le prêteur pour avoir plus
				d’informations et prendre rendez-vous avec lui. </p>
				<h3>2- Emprunt</h3>
				<p>- Je vérifie l’état de l’objet et je le récupère lors du rendez-vous.</p>
				<p>- J’en profite!</p>
				<p>- Quand la durée de prêt arrive à échéance, je prends rendez-vous avec
				le prêteur et lui rends l’objet dans l’état initial.</p>
				<h3>3- Avis</h3>
				<p>- Je laisse un avis au prêteur et je spécifie si j’ai été satisfait de 
				l’échange afin que <i> <b>Pradéens Solidaires </b></i> puisse s’améliorer.</p>
				<p>- Je prête à mon tour mes objets à un(e) pradéen(ne)!</p>
			</div>
			<div class="col-xs-offset-2 col-xs-4 aide">
				<h2>JE PRÊTE</h2>
				<h3>1- Proposition et Validation</h3>
				<p>- Je propose les objets que je veux prêter sur le site Pradéens Solidaires
				en spécifiant son nom, la catégorie et son état.</p>
				<p>- Je reçois une demande d’emprunt et l’accepte si cela me convient.</p>
				<p>- Je prend rendez-vous avec l’emprunteur.</p>
				<p>- Je peux modifier la durée de mon prêt à tout moment.</p>
				<h3>2- Prêt</h3>
				<p>- Je prête l’objet lors du rendez-vous.</p>
				<p>- Je prends rendez-vous pour récupérer l’objet.</p>
				<p>- Je vérifie qu’il est dans l’état initial.</p>
				<h3>3- Avis</h3>
				<p>- Je laisse un avis à l’emprunteur et je spécifie si j’ai été satisfait de
				l’échange afin que  <i> <b> Pradéens Solidaires </b></i> puisse s’améliorer.</p>
				<p>- J’emprunte les objets dont j’ai besoin.</p>
		</div>
	</div>
</div>
</div>
