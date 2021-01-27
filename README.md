Egutegia
============

Pasaiako Udaletxeko langileen egutegiak kudeatzeko web aplikazioa.

   `app/config/parameters.yml` fitxategia bete beharrezko datuekin
   

Bikoiztutako filak ezabatzeko MYSQL-n

    DELETE t1 FROM notification t1
             INNER JOIN
         notification t2 
     WHERE
         t1.id > t2.id 
         and t1.description = t2.description 
         and t1.eskaera_id = t2.eskaera_id 
         and t1.firma_id=t2.firma_id 
         and t1.name = t2.name 
         and t1.user_id = t2.user_id;   

Requirements:
- Beharrezkoaz da wkhtmltopdf instalatua izatea zerbitzarian:
    - EZ ERABILI => sudo apt-get install wkhtmltopdf => EZ DABIL!!!
    - lib barruan dagoena instalatu (Debian 8 bertsioa)
    - eskuratu non instalatua dagoen => whereis wkhtmltopdf

