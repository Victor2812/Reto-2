# Reto-2

## Levantar servidor

Para levantar el servidor:
```bash
docker compose up -d
```

Para destruir el servidor de desarrollo:
```bash
docker compose stop
# ó
docker compose down
```

### ⚠️ A tener en cuenta

La carpeta "src/uploads/" necesitará ser accesible por el usuario "www-data".

En su defecto, con el siguiente comando sería suficiente:
```bash
chmod -R 777 src/uploads/
```

### Base de datos

Credenciales de PHPMyAdmin:
- Usuario: root
- Contraseña: Jm12345

Credenciales del servidor MariaDB para usar en PHP:
- Usuario: aerbide
- Contraseña: Jm12345

### Enlaces

- [PHPMyAdmin](http://localhost:8888/) (localhost)
- [Servidor PHP](http://localhost:8080/) (localhost)