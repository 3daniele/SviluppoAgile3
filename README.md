# SharedMusic<br>Sviluppo AGILE 2019-2020
Progetto realizzato per il corso di Sviluppo AGILE
## Installazione
#### Requisiti
- Aver installato e configurato git
- Server web compatibile con php versione 7.<sub>*</sub>
- Aver installato composer
#### Operazioni
1. Clonare il repository nella directory desiderata<br>
`git clone https://github.com/3daniele/SviluppoAgile3.git `
2. Spostarsi all'interno della directory del progetto<br>
`cd Project`
3. Installare tutte le dipendenze necessarie al funzionamento del progetto<br>
`composer install`
4. Configurare i dati nel file .env.example e copiare le informazioni in un nuovo file .env<br>
`cp .env.example .env`
5. Generare la chiave univoca<br>
`php artisan key:generate`
6. Popolare il database con i dati pre configurati<br>
`php artisan migrate:fresh --seed`
7. Avviare il server<br>
`php artisan serve`
###### Per qualsiasi dubbio consultare la documentazione di [Laravel](https://laravel.com/docs/7.x)
## Indirizzi email:
- <b>Domenico Bonali</b>, 254023, domenico.bonali@student.univaq.it;
- <b>Daniele Di Desidero</b>, 251850, daniele.desidero@student.univaq.it;
- <b>Chiara Michelucci</b>, 252633, chiara.michelucci@student.univaq.it;
- <b>Francesca Santoferrara</b>, 252167, francesca.santoferrara@student.univaq.it;