workerman-chat
=======
Este repositorio es una copia de https://github.com/walkor/workerman-chat

GatewayWorker documentacion：http://www.workerman.net/gatewaydoc/
 

AÑADIDO
=====
En start_businessworker.php se añadio un Worker para la realizacion de consultas de manera asincrona

Recibe la query (string) y retorna los datos en json

 
INSTALL
=====
1、git clone https://github.com/walkor/workerman-chat

2、composer install

LINUX
=====
debug
```php start.php start  ```

como demonio
```php start.php start -d ```

WINDOWS
======
start_for_win.bat

stop reload status

REFERENCIA
======
 Pagina oficial : www.workerman.net
