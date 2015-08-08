#Documentaci�n diagramas 

Aqu� residir� toda la documentaci�n pertinente y relativa a los diagramas. 

## Diagrama de clases 

El diagrama de clases captura el vocabulario del sistema. Este diagrama se crea en las primeras fases de modelado y se va refinando a lo largo de todo el proceso de desarrollo. 
El principal prop�sito del Diagrama de Clases se puede resumir en tres puntos:

	�Nombrar y modelar conceptos del sistema.
	�Especificar colaboraciones.
	�Especificar esquemas l�gicos de bases de datos.

######Modelo de dominio 

El modelo de dominio da una representanci�n visual de las clases del dominio, sus relaciones, y cualquier atributo de ellas. 

######Modelo de dise�o 

El modelo de dise�o representa como todas las clases van a trabajar en conjunto, como se conectan entre ellas, y como se comunicar�n. Depende del lenguaje, y del
framework que se use. Normalmente se aplican patrones DAO (Data Access Object->Donde se realizar�n toda la interacci�n con la BD), DTO(Data Transfer Object-> Solo representan las entidades y es usado por el DAO y BO),
y BO (Business Object->Representa la l�gica de negocio de la aplicaci�n). En nuestro caso al estar usando Laravel Framework el cual se basa en el patr�n MVC, nuestros Modelos actuar�n como DAO, nuestras entidades definidas,
como DTO, y nuestros controladores como BO. En el diagrama se puede apreciar que son definidos los interfaces para los DAO, y estos ser�n implementados por nuestros Modelos. 