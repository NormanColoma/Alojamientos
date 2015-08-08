#Documentación diagramas 

Aquí residirá toda la documentación pertinente y relativa a los diagramas. 

## Diagrama de clases 

El diagrama de clases captura el vocabulario del sistema. Este diagrama se crea en las primeras fases de modelado y se va refinando a lo largo de todo el proceso de desarrollo. 
El principal propósito del Diagrama de Clases se puede resumir en tres puntos:

	–Nombrar y modelar conceptos del sistema.
	–Especificar colaboraciones.
	–Especificar esquemas lógicos de bases de datos.

######Modelo de dominio 

El modelo de dominio da una representanción visual de las clases del dominio, sus relaciones, y cualquier atributo de ellas. 

######Modelo de diseño 

El modelo de diseño representa como todas las clases van a trabajar en conjunto, como se conectan entre ellas, y como se comunicarán. Depende del lenguaje, y del
framework que se use. Normalmente se aplican patrones DAO (Data Access Object->Donde se realizarán toda la interacción con la BD), DTO(Data Transfer Object-> Solo representan las entidades y es usado por el DAO y BO),
y BO (Business Object->Representa la lógica de negocio de la aplicación). En nuestro caso al estar usando Laravel Framework el cual se basa en el patrón MVC, nuestros Modelos actuarán como DAO, nuestras entidades definidas,
como DTO, y nuestros controladores como BO. En el diagrama se puede apreciar que son definidos los interfaces para los DAO, y estos serán implementados por nuestros Modelos. 

## Diagrama de base de datos 

A destacar: 

	-Los usuarios serán almacenados en la misma tabla aunque tengan roles diferentes, por eso existen 2 claves para identificarlos (admin,owner). Si ninguna 
	 de las dos claves es **_true_**, significa que el usario es un viajero normal. 
	-La tabla **_Note_**, tiene dos foreing key, una para identificar al usuario al que pertenece la nota, y otra para saber sobre quien es la nota. 
	-Tanto las reservas como las preresevas, serán almacenadas en la misma tabla **_Booking_:**. El campo prebooking, es el que indica si es una reserva o preserva. 
	-Un usuario no puede tener en la misma fecha y para el mismo alojamiento más de una reserva, por ello la clave principal de la tabla Booking está compuesta por
	 tres claves: **_date,idUser,idAccomodation_**. Además, la clave **_id_**, es única ya que es el id de la reserva. 
	-Un usuario no podrá tener más de 1 voto para el mismo alojamiento, por eso la clave de la tabla Vote está compuesta por: **_userId,accomodationID_:**. Además,
	 tendrá una unique key, que será el id del voto.
