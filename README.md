Wownalytics!
============

Implementación para back-end.

Consiste en un servicio CRON que recorre la base de datos con las conexiones
para las diferentes APIs que hayan sido configuradas por cuenta y acumula los datos
progresivamente para ser consultados posteriormente.

Estos datos deberán ser accesibles mediante una API RESTful para la comodidad del front-end.


## API

  - ### Usuarios

    Para poder acceder al servicio debe registrarse una cuenta de e-mail.

        # obtiene información del usuario
        GET /user?email=@addr
          => @account

        # registra un usuario nuevo
        POST /user?email=@addr
          => @account

        # elimina un usuario
        DELETE /user?email=@addr
          => @account

  - ### Proveedores

    Los proveedores son vinculados usando el hash-id devuelto por el proceso de registro.

        # obtiene datos del proveedor
        GET /@provider?id=@account
          => @service

        # actualiza datos del proveedor
        PUT /@provider?id=@account
          => @service

        # registra un proveedor nuevo
        POST /@provider?id=@account
          => @service

        # elimina un proveedor
        DELETE /@provider?id=@account
          => @service

  - ### Servicios

    Los servicios se configuran utilizando el hash-id devuelto por el proceso de vinculación.

        #
        GET /@provider/@action?hash=@service
          => @datum

        #
        PUT /@provider/@action?hash=@service
          => @datum

        #
        POST /@provider/@action?hash=@service
          => @datum

        #
        DELETE /@provider/@action?hash=@service
          => @datum

  - ### Datos acumulados

    Los datos acumulados son devueltos utilizando el hash-id devuelto por el proceso de configuración.

        # consume datos unicamente
        GET /@provider/@action/@what?provide=@datum
          => @json
