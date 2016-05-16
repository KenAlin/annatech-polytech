# Annatech-Polytech
:mortar_board: Rendu du site Annatech, pour Polytech Montpellier (projet web IG3)

## Notes
* Nécessite la configuration d'une base de données dans le fichier `/application/config/database.php` et du serveur SMTP pour les mails de validation de compte membre, ligne 242 du fichier `/application/controller/Api.php`.
* Attention : le mail de confirmation peut mettre jusqu'à deux heures pour passer les filtres anti spam mis en place par Polytech. Ce délai est indépendant d'AnnaTech, je ne peux rien y faire.
* Le fichier `init.sql` contient les instructions nécessaires à la mise en place de la base de données, avec quelques exemples.