## Passo a passo para utilizar o projeto ##
 
 A navbar contém um **fluxo de uso**, sendo o primeiro **CRUD** necessário o de clientes > produtos > pedidos.

 Cada linha possui um botão de **detalhes** para ver uma visão geral do que está acontecendo com aquele cliente, produto ou pedido.

 Todos os CRUDs podem ser filtrados.



**1. /home**

 Tem uma barra de visão geral dos status dos pedidos e quantidade, assim como quantidade de clientes e quantos estão com pedidos, produtos cadastrados também.

 Exibe o faturamento potencial, faturamento realizado, pedidos cancelados.

 Top Hits são os 3 produtos que mais foram adicionado por clientes nos seus pedidos.

 _Cada card tem um link para a página do seu respectivo CRUD._

**2. /clientes**

 Visão geral dos clientes, primeiro passo é criar um cliente seguindo as regras do formulário.

 Após criado terá uma linha com os detalhes do cliente, logo abaixo do nome tem um link que direcionará para a página /pedidos com o id do usuário filtrado.

 Botão detalhes, mostra os detalhes do cliente e seu histórico de pedidos.

**3. /produtos**

 Visão geral dos produtos, assim como clientes é necessário ter pelo menos um produto cadastrado para criar um pedido.

 Os produtos possuem um botão de detalhes que mostram quantos pedidos estão com aquele item, assim como detalhes do mesmo.

**4. /pedidos**
 
 Logo após ter criado pelo menos um cliente e produto, o pedido está pronto para ser criado, com um form que está atrelado diretamente com os dois anteriores.

 Os detalhes na linha de pedidos exibem as informações do cliente, do pedido, e também dos produtos daquele pedido.








        
