		<?php if(isset($_SESSION['charte_fail'])){
            if($_SESSION['charte_fail']==1){
                echo '
                <div class="alert alert-info alert-dismissable">
					<a href="./index.php?controller=utilisateur&action=charte" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong>Vous n\'avez pas lu et accepté la charte ou/et accepté les règles d\'utilisation du site, veuillez réessayer ! </strong>
                </div>';
				$_SESSION['charte_fail']=0;
            }
        } 
?>
<div class="body row charte">
	<div class="col-xs-12 row ">	
		<form class="col-offset-sm-3 col-xs-6" id="form1" method="post" action="./index.php?controller=utilisateur&action=charteOK">
			<div style="background-color:white;text-align:justify;border:ridge;color:black;" class="row">
				<h2 style="text-align:center;"> Charte Générale </h2>
				<p> Le CCAS de Prades-le-Lez, en partenariat avec la municipalité, a choisi de mettre en œuvre le projet « <b><cite style="color:green">Pradéens Solidaires</cite></b> » qui consiste à créer une plate-forme informatique favorisant les échanges de biens matériels entre Pradéennes et Pradéens. Ce projet a pour but de renforcer la solidarité au sein de notre commune, tout en permettant la mutualisation des biens possédés et la promotion du bien-vivre-ensemble en renforçant le dialogue entre Pradéennes et les Pradéens d’un même immeuble, d’une même rue, d’un même quartier, d’une même commune et ce dans le respect des différences de chacun.</p>
				<p> Un comité de pilotage constitué de 2 élu(e)s et de quelques bénévoles -qui sont les garants de l’éthique du projet- est à l’initiative de la réflexion et du lancement de ce projet.</p>
				<p>Toute personne résidant à Prades-le-Lez qui souhaite bénéficier de cette plate-forme d’échanges de biens doit proposer un bien à mutualiser pour devenir « <b><cite style="color:green"> Pradéenne ou Pradéen Solidaire </cite></b> » .</p>
				<p> Une fiche d’adhérent « <b><cite style="color:green"> Pradéens Solidaires </cite></b> » est à remplir sur le site www.pradeenssolidaires.fr en indiquant votre identité, votre lieu de résidence et le numéro de votre assurance Responsabilité civile, sans oublier le ou les objets que vous souhaitez prêter et sur quelle durée. Votre inscription reçoit alors une validation de la part de l’administrateur du site.
				Pour permettre une transaction dans les meilleures conditions, une fiche d’échange est transmise par courriel au prêteur qui la remplit et la signe, puis la fait remplir et signer à l’emprunteur.
A la fin de chaque transaction, une appréciation est donnée sur la qualité de l’échange. A la 3ème mauvaise appréciation, l’adhésion sera momentanément suspendue.</p>
				<p> Afin de garantir l’intégrité de cette démarche et la bonne utilisation de votre inscription, chaque adhérent s’engage à respecter les règles suivantes propres à <b><cite style="color:green"> Pradéens Solidaires </cite></b> : </p>

				<p> Agir dans le bien d’autrui et de manière toujours désintéressée</p>

				<p> Faire preuve de courtoisie en toute occasion </p>

				<p> Ne solliciter et/ou percevoir en aucun cas et sous quelque forme que ce soit une rétribution pour une action menée dans le cadre de <cite style="color:green"> Pradéens Solidaires </cite> </p>
				<p> <b> <input type="checkbox" id="conf_charte" name="conf_charte" value="1" /> J'ai bien lu la charte et je m’engage à respecter les dispositions prévues par la Charte de Pradéens Solidaires. </b></p>
				<p> <b> <input type="checkbox" id="conf_use" name="conf_use" value="1" /> J'adhère aux règles et aux conditions d'utilisation de cette plateforme d'échange. </b></p>							
			</div>	
			<div class="row">
				<p class="col-md-offset-2"><input type="submit" value="Continuer l'inscription"/></p>
			</div>
		</form>
	</div>
</div>
