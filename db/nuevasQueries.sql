CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    dni VARCHAR(8) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    rol VARCHAR(20) NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE novedades (
  id INT AUTO_INCREMENT PRIMARY KEY,
  descripcion VARCHAR(255) NOT NULL,
  orden INT NOT NULL
);

INSERT INTO novedades (descripcion, orden) VALUES ('¡Nuevo manga agregado a la tienda!', 1);
INSERT INTO novedades (descripcion, orden) VALUES ('Promociones activas este mes.', 2);
INSERT INTO novedades (descripcion, orden) VALUES ('Revisa tus compras recientes.', 3);