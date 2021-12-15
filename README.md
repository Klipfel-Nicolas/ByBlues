# Project 3 Bye Blues

![Cover](https://github.com/Klipfel-Nicolas/ByBlues/blob/master/assets/imageReadme/byeblues-clair_1.png)

Bye Blues est une start-up Strasbourgeoise.

Bye Blues  offre une solution inspirée d’études scientifiques récentes. En reproduisant une lumière rouge de 630 nm naturellement présente dans les rayons du soleil, la lampe "bye blues" réduit considérablement les conséquences négatives d'un réveil à éclairages artificiels et favorise ainsi un endormissement plus facile et un sommeil plus réparateur pour un réveil en meilleure forme.

## Description

Le site est composé : 
- D'une page de présentation du produit et du projet Bye blues
- D'un blog afin de partager des articles scientifiques ou sociologiques
- D'une boutique en ligne pour commander le produit (sans système de payement)
- D'une partie Admin
- D'un système d'authentification sign-in, log-in/log-out

### La base de donnée

UML         |  
:-------------------------:|
![](https://github.com/Klipfel-Nicolas/ByBlues/blob/master/assets/imageReadme/BDD-byBlues.png) | 
bdd mySql |
:-------------------------:|
![](https://github.com/Klipfel-Nicolas/ByBlues/blob/master/assets/imageReadme/bdd.png) |

### La boutique en ligne

La boutique      |  Le pannier
:-------------------------:|:-------------------------:
![](https://github.com/Klipfel-Nicolas/ByBlues/blob/master/assets/imageReadme/boutique.gif) | ![](https://github.com/Klipfel-Nicolas/ByBlues/blob/master/assets/imageReadme/pannier.gif)
Mise à jour en direct du statut avec le nombre total d'items | Suppression d'un item avec calcul immédiat du nouveau montant total

#### La commande.

![Alt](https://github.com/Klipfel-Nicolas/ByBlues/blob/master/assets/imageReadme/commande.gif)

La commande est stockée dans l'historique des commandes d'un utilisateur dans son espace personnel, avec le détail de celle-ci.


## Construit avec

* [Symfony](https://github.com/symfony/symfony)
* [GrumPHP](https://github.com/phpro/grumphp)
* [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer)
* [PHPStan](https://github.com/phpstan/phpstan)
* [PHPMD](http://phpmd.org)
* [ESLint](https://eslint.org/)
* [Sass-Lint](https://github.com/sasstools/sass-lint)

