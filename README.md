# O'wine

## Projet de fin de formation : 
- 1 mois 
- équipe de 5 personnes
- full Symfony

Ce projet a pour but de résoudre les difficultés que rencontrent les vendeurs de vin (producteurs, cavistes) lorsqu’ils reçoivent des groupes qui viennent déguster dans leur boutique.

Le site leur permet de gagner du temps dans leur processus de vente. Les vendeurs peuvent faire déguster leurs produits tandis que les visiteurs procèdent à leur achats en toute autonomie sans avoir besoin de faire “la queue à la caisse”.

## Installation :

Créer un fichier .env.local avec :
```shell
DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=5.7

###> nelmio/cors-bundle ###
CORS_ALLOW_ORIGIN=^https?://(localhost|127\.0\.0\.1)(:[0-9]+)?$
###< nelmio/cors-bundle ###
VIGNOBLEXPORT_TOKEN=***********************************************************
```

Dans le terminal :
```shell
composer install
```
```shell
php bin/console doctrine:database:create
```
```shell
php bin/console doctrine:migrations:migrate
```
```shell
php bin/console doctrine:fixtures:load
```

Login :
```shell
buyer@mail.fr
banane

seller@mail.fr
banane

admin@mail.fr
banane
```

## Exemple de page du site : 

### Page d'accueil : 

![homepage](/public/images/readme/homepage.png)

### Liste des boutiques : 

![shopList](/public/images/readme/shopList.png)

### Liste des produits :

![productList](/public/images/readme/productList.png)

### Détail d'un produit :

![productShow](/public/images/readme/productShow.png)

### Panier de l'acheteur :

![cart](/public/images/readme/cart.png)

### Commande de l'acheteur :

![orderShowBuyer](/public/images/readme/orderShowBuyer.png)

### Commande du vendeur :

![orderShowSeller](/public/images/readme/orderShowSeller.png)

### Profil :

![profile](/public/images/readme/profile.png)

### Backoffice (easyAdmin)

![backoffice](/public/images/readme/easyAdmin.png)


