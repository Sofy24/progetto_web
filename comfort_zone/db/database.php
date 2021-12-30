<?php
class DatabaseHelper{
    private $db;

    public function __construct($servername, $username, $password, $dbname, $port){
        $this->db = new mysqli($servername, $username, $password, $dbname, $port);
        if ($this->db->connect_error) {
            die("Connection failed: " . $db->connect_error);
        }        
    }


    //get generali
    public function getCategories(){
        $stmt = $this->db->prepare("SELECT id_categoria, nome FROM categoria ");
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getDelivererInfo($username_fattorino){
        $stmt = $this->db->prepare("SELECT *
        FROM fattorino 
        WHERE username_fattorino = ?
        LIMIT 1");
        $stmt->bind_param('s',$username_fattorino);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getIdFromTag($tag){//restituisce l'id del tag passato
        $stmt = $this->db->prepare("SELECT id_tag FROM tag WHERE nome = ? LIMIT 1");
        $stmt->bind_param('s',$tag);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getOrdredProducts(){
        $stmt = $this->db->prepare("SELECT id_prodotto FROM prodotto ORDER BY id_prodotto LIMIT 1");
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getProductById($id_prodotto){
        $stmt = $this->db->prepare("SELECT id_prodotto, quantità, prezzo_unitario, nome, descrizione, id_categoria, username_venditore
        FROM prodotto WHERE id_prodotto = ? LIMIT 1");
        $stmt->bind_param('i',$id_prodotto);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);   
    }

    public function getProductsByTags($tags){//ricerca i prodotti sulla base dei tags passati
        $number_of_tags = count($tags);
        $tags_max_dimension = 5;
        $tags = array_pad($tags, $tags_max_dimension, 0);//aggiunge tanti 0 quanti necessari per avere 5 elementi
        array_push($tags,$number_of_tags);//tag effettivi presenti
        $stmt = $this->db->prepare("SELECT p.id_prodotto, quantità, prezzo_unitario, nome, descrizione, id_categoria, username_venditore 
        FROM prodotto as p, tag_del_prodotto as t
        WHERE p.id_prodotto = t.id_prodotto
        AND t.id_tag IN (?, ?, ?, ?, ?)
        GROUP BY t.id_prodotto
        HAVING COUNT(t.id_tag) >= ?
        ORDER BY quantità DESC;");
        $stmt->bind_param('iiiiii',...$tags);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);        
    }

    public function getProductsBySeller($username_venditore){//restituisce i prodotti di uno specifico venditore
        $stmt = $this->db->prepare("SELECT id_prodotto, quantità, prezzo_unitario, nome, descrizione, id_categoria, username_venditore
        FROM prodotto 
        WHERE username_venditore = ?
        ORDER BY nome");
        $stmt->bind_param('s',$username_venditore);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);       
    }

    public function getProductsFromCategories($categoria){//resituisce tutti i prodotti della categoria passata
        $stmt = $this->db->prepare("SELECT id_prodotto, quantità, prezzo_unitario, nome, descrizione, id_categoria, username_venditore 
        FROM prodotto 
        WHERE id_categoria = ? ");
        $stmt->bind_param('i',$categoria);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getRandomCategories(){
        $stmt = $this->db->prepare("SELECT id_categoria, nome FROM categoria ORDER BY RAND() LIMIT 10");
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getRandomProducts(){
        $stmt = $this->db->prepare("SELECT * FROM prodotto ORDER BY RAND() LIMIT 10");
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getRandomProductByTag($id_tag, $id_prodotto){//prende un prodotto per ogni tag
        $stmt = $this->db->prepare("SELECT p.id_prodotto, p.nome FROM prodotto as p, tag_del_prodotto as t 
        WHERE p.id_prodotto = t.id_prodotto
        AND t.id_tag = ?
        AND p.id_prodotto <> ?
        ORDER BY RAND() LIMIT 1");
        $stmt->bind_param('ii',$id_tag, $id_prodotto);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getRandomProductsFromCategories($categoria){//prende un prodotto appartenente alla categoria passata
        $stmt = $this->db->prepare("SELECT id_prodotto FROM prodotto WHERE id_categoria = ? ORDER BY RAND() LIMIT 1");
        $stmt->bind_param('i',$categoria);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    public function getSellerInfo($username_venditore){
        $stmt = $this->db->prepare("SELECT *
        FROM venditore 
        WHERE username_venditore = ?
        LIMIT 1");
        $stmt->bind_param('s',$username_venditore);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);        
    }

    public function getTags(){
        $stmt = $this->db->prepare("SELECT id_tag, nome FROM tag");
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getTagsByProduct($id_prodotto){
        $stmt = $this->db->prepare("SELECT tp.id_tag, t.nome FROM tag_del_prodotto as tp, tag as t 
        WHERE tp.id_tag = t.id_tag
        AND id_prodotto = ?");
        $stmt->bind_param('i',$id_prodotto);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);         
    }

    //sezione carrello
    public function getAllUserProducts($username_utente){//restituisce le informazioni su tutti i prodotti nel carrello dell'utente
        $stmt = $this->db->prepare("SELECT pc.*, p.prezzo_unitario, nome, p.quantità AS quantità_residua, descrizione, id_categoria, username_venditore 
        FROM Prodotto_in_Carrello as pc, prodotto as p
        WHERE pc.id_prodotto = p.id_prodotto 
        AND username_utente = ?
        ORDER BY p.nome");
        $stmt->bind_param('s',$username_utente);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);   
    }

    public function updateProductQuantity($id_prodotto, $change_value){//aggiorna la quantità disponibile di un prodotto
        $quantità_in_magazzino = ($this->getProductById($id_prodotto))[0]["quantità"];
        if ($quantità_in_magazzino > -1){
            $quantità_in_magazzino = $quantità_in_magazzino + $change_value;
            if ($quantità_in_magazzino < 0){
                $quantità_in_magazzino = 0;
            }
        }
        $stmt = $this->db->prepare("UPDATE prodotto SET quantità = ? WHERE id_prodotto = ?");
        $stmt->bind_param("ii", $quantità_in_magazzino, $id_prodotto);
        $stmt->execute();
    }

    public function isAlreadyInCart($id_prodotto, $username_utente){//verifica se il prodotto è nel carrello dell'utente corrente
        $stmt = $this->db->prepare("SELECT count(*) FROM Prodotto_in_Carrello WHERE username_utente=? AND id_prodotto=? ");
        $stmt->bind_param('si',$username_utente, $id_prodotto);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getProductInCartQuantity($id_prodotto, $username_utente){//restituisce la quantità di un prodotto nel carrello di un utente
        $stmt = $this->db->prepare("SELECT quantità FROM Prodotto_in_Carrello WHERE username_utente=? AND id_prodotto=? ");
        $stmt->bind_param('si',$username_utente, $id_prodotto);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);   
    }

    public function addProductToCart($id_prodotto, $username_utente){//aggiunge un prodotto al carrello o ne incrementa la quantità se già esiste
        if (($this->getProductById($id_prodotto))[0]["quantità"] == 0){
            return false;
        }
        $this->updateProductQuantity($id_prodotto, -1);
        if (($this->isAlreadyInCart($id_prodotto, $username_utente))[0]["count(*)"] == 1){//se già esiste
            $nuova_quantita = ($this->getProductInCartQuantity($id_prodotto, $username_utente))[0]["quantità"] + 1;
            $stmt = $this->db->prepare("UPDATE Prodotto_in_Carrello SET quantità = ? WHERE id_prodotto = ? AND username_utente = ?");
            $stmt->bind_param("iis", $nuova_quantita, $id_prodotto, $username_utente);
            $stmt->execute();
        }
        else {//se è nuovo
            $stm = $this->db->prepare("INSERT INTO `Prodotto_in_Carrello` (`id_prodotto`, `username_utente`, `quantità`) VALUES (?, ?, 1)");
            $stm->bind_param("is", $id_prodotto, $username_utente);
            $stm->execute();
        }
    }

    public function deleteProductFromCart($id_prodotto, $username_utente){//cancella il prodotto nel carrello. ripristina la quantità disponibile
        $this->updateProductQuantity($id_prodotto, ($this->getProductInCartQuantity($id_prodotto, $username_utente))[0]["quantità"]);
        $stmt = $this->db->prepare("DELETE FROM Prodotto_in_Carrello WHERE id_prodotto=? AND username_utente = ?");
        $stmt->bind_param("is", $id_prodotto, $username_utente);
        $stmt->execute();
    }

    public function removeProductFromCart($id_prodotto, $username_utente){//rimuove 1 unità del prodotto dal carrello selezionato. se quantità==0 lo rimuove
        if (($this->getProductInCartQuantity($id_prodotto, $username_utente))[0]["quantità"] == 0){
            return false;
        }
        $this->updateProductQuantity($id_prodotto, 1);
        $nuova_quantita = ($this->getProductInCartQuantity($id_prodotto, $username_utente))[0]["quantità"] - 1;
        if ($nuova_quantita > 0){//quantità > 0
            $stmt = $this->db->prepare("UPDATE Prodotto_in_Carrello SET quantità = ? WHERE id_prodotto = ? AND username_utente = ?");
            $stmt->bind_param("iis", $nuova_quantita, $id_prodotto, $username_utente);
            $stmt->execute();
        }
        else {//quantità == 0
            $stmt = $this->db->prepare("DELETE FROM Prodotto_in_Carrello WHERE id_prodotto=? AND username_utente = ?");
            $stmt->bind_param("is", $id_prodotto, $username_utente);
            $stmt->execute();   
        }
    }
    
    public function getCartNumber($username){
        $stmt = $this->db->prepare("SELECT COUNT(id_prodotto) as num FROM prodotto_in_carrello 
        WHERE username_utente = ?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);        
    }

    //elaborazioni sul prodotto
    public function deleteProduct($id_prodotto){//cancella un prodotto
        $stm = $this->db->prepare("DELETE FROM prodotto WHERE id_prodotto = ?");
        $stm->bind_param("i", $id_prodotto);
        $stm->execute();
        $result = $stm->get_result();
    }

    public function getLastProductId(){//restituisce l'id più alto della tabella prodotto
        $stm = $this->db->prepare("SELECT id_prodotto FROM prodotto ORDER BY id_prodotto DESC LIMIT 1");
        $stm->execute();
        $result = $stm->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);   
    }

    public function getProductByIdAndVenditore($id, $venditore){
        $query = "SELECT id_prodotto as id, quantità , prezzo_unitario, nome, descrizione, id_categoria, username_venditore, 
        (SELECT GROUP_CONCAT(id_tag) FROM tag_del_prodotto WHERE id_prodotto=id GROUP BY id_prodotto) as tag 
        FROM prodotto WHERE id_prodotto=? AND username_venditore=?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('is',$id, $venditore);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function insertTagsOfProduct($prod, $tag){
        $stm = $this->db->prepare("INSERT INTO `tag_del_prodotto` (`id_prodotto`, `id_tag`) VALUES (?, ?)");
        $stm->bind_param("ii", $prod, $tag);
        $stm->execute();
    }

    public function deleteTagsOfProduct($id){
        $stm = $this->db->prepare("DELETE FROM tag_del_prodotto WHERE id_prodotto = ?");
        $stm->bind_param("i", $id);
        $stm->execute();
    }

    public function updateProductOfVenditore($quantità, $prezzo_unitario, $nome, $descrizione, $id_categoria, $username_venditore, $id ){
        $stm = $this->db->prepare("UPDATE prodotto  SET quantità = ?, prezzo_unitario= ?, nome= ?, descrizione= ?, id_categoria= ? WHERE username_venditore= ? AND id_prodotto = ?");
        $stm->bind_param("idssisi", $quantità, $prezzo_unitario, $nome, $descrizione, $id_categoria, $username_venditore, $id);
        $stm->execute();
    }

    public function insertTagOfProduct($prod, $tag){
        $stm = $this->db->prepare("INSERT INTO `tag_del_prodotto` (`id_prodotto`, `id_tag`) VALUES (?, ?)");
        $stm->bind_param("ii", $prod, $tag);
        $stm->execute();
    }
    
    public function deleteTagOfProduct($prod, $tag){
        $stm = $this->db->prepare("DELETE FROM tag_del_prodotto WHERE id_prodotto = ? AND id_tag = ?");
        $stm->bind_param("ii", $prod, $tag);
        $stm->execute();
    }

    //query non meglio catalogate
    public function getAllSeller(){
        $stmt = $this->db->prepare("SELECT * FROM venditore");
        $stmt->execute();
        $result = $stmt->get_result();  

        return $result->fetch_all(MYSQLI_ASSOC); 
    }

    public function getProductsFromSeller($username_venditore){
        $stmt = $this->db->prepare("SELECT id_prodotto, quantità, prezzo_unitario, nome, descrizione, id_categoria, username_venditore 
        FROM prodotto WHERE username_venditore = ? ");
        $stmt->bind_param('s',$username_venditore);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }



    public function getAllClassroom(){
        $stmt = $this->db->prepare("SELECT * FROM aula");
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    //sezione ordine
    public function getBestDeliverer(){//restituisce il fattorino con meno consegne da fare attive
        $stmt = $this->db->prepare("SELECT * FROM fattorino 
        ORDER BY ordini_correnti
        LIMIT 1");   
        $stmt->execute();
        $result = $stmt->get_result();  
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function createOrder($username_utente, $aula){//crea l'ordine e lo assegna a un fattorino, ritorna l'id dell'ordine
        //creazione ordine
        $fattorino = $this->getBestDeliverer()[0];
        $stm = $this->db->prepare("INSERT INTO `ordine` (data_ordine, consegnato, numero_aula, username_fattorino, username_utente) 
        VALUES (?, 0, ?, ?, ?)");
        $current_date = date("Y-m-d H:i");
        $stm->bind_param("ssss", $current_date , $aula, $fattorino["username_fattorino"], $username_utente);
        $stm->execute();
        $id = $stm->insert_id;//id dell'ordine
        //assegnamento fattorino
        $numero_ordini = $fattorino["ordini_correnti"] + 1;
        $stmt = $this->db->prepare("UPDATE Fattorino SET ordini_correnti = ? WHERE username_fattorino = ?");
        $stmt->bind_param("is", $numero_ordini, $fattorino["username_fattorino"]);
        $stmt->execute();
        //notifica il fattorino dell'ordine
        $testo="hai un nuovo ordine da consegnare a ".$username_utente." nell'aula: ".$aula;
        $this->notify($testo, "<a href='index.php'>Comfort Zone</a>", $fattorino["username_fattorino"]);
        return $id;
    }

    public function cartToOrder($username_utente, $aula){//converte il carrello corrente in un ordines
        $id_ordine = ($this->createOrder($username_utente, $aula));
        $carrello = $this->getAllUserProducts($username_utente);
        foreach($carrello as $prodotto_in_carrello){
            $stm = $this->db->prepare("INSERT INTO `prodotto_in_ordine` (id_prodotto, id_ordine, quantità) 
            VALUES (?, ?, ?)");
            $stm->bind_param("iii", $prodotto_in_carrello["id_prodotto"], $id_ordine, $prodotto_in_carrello["quantità"]);
            $stm->execute();
        }
        foreach($carrello as $prodotto_in_carrello){//svuota carrello corrente
            $this->deleteProductFromCart($prodotto_in_carrello["id_prodotto"], $username_utente);  
        }
        return $id_ordine;
    }
    
    public function getOrderedProducts($username_utente){//prodotti ordinati nel senso di ordinazione
        $stmt = $this->db->prepare("SELECT po.id_prodotto, po.quantità, o.*, p.nome, p.descrizione, p.username_venditore, p.prezzo_unitario 
        FROM prodotto_in_ordine as po, ordine o, prodotto as p 
        WHERE po.id_ordine = o.id_ordine
        AND po.id_prodotto = p.id_prodotto
        AND o.username_utente = ?
        ORDER BY o.id_ordine DESC");
        $stmt->bind_param('s', $username_utente);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);  
    }

    public function getAllOrder(){
        $stmt = $this->db->prepare("SELECT * FROM Ordine o
        ORDER BY id_ordine DESC");
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC); 
    }

    public function getOrdersByDeliverer($username_fattorino){
        $stmt = $this->db->prepare("SELECT * FROM Ordine o, utente u 
        WHERE o.username_utente = u.username_utente 
        AND username_fattorino = ?
        ORDER BY id_ordine DESC");
        $stmt->bind_param('s',$username_fattorino);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getDelivererByOrder($id_ordine){
        $stmt = $this->db->prepare("SELECT * FROM fattorino f, ordine o
        WHERE  f.username_fattorino = o.username_fattorino
        AND o.id_ordine = ?");
        $stmt->bind_param('i',$id_ordine);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);    
    }

    public function getUserByOrder($id_ordine){
        $stmt = $this->db->prepare("SELECT * FROM utente u, ordine o
        WHERE u.username_utente = o.username_utente
        AND o.id_ordine = ?");
        $stmt->bind_param('i',$id_ordine);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);    
    }

    public function deliverOrder($id_ordine){
        $current_date = date("Y-m-d H:i");
        $stmt = $this->db->prepare("UPDATE Ordine SET consegnato = 1, data_consegna = ? WHERE id_ordine = ?");
        $stmt->bind_param("si", $current_date, $id_ordine);
        $stmt->execute();

        //notifica: consegna effettuata
        $testo = "consegna effettuata alle ".date("H:i:s")." del ".date("d/m/Y");
        $dati_sender = ($this->getDelivererByOrder($id_ordine))[0];
        $username_sender = $dati_sender["username_fattorino"]; 
        $username_receiver = ($this->getUserByOrder($id_ordine))[0]["username_utente"];
        $this->notify($testo, $username_sender, $username_receiver);

        //rimuove un ordine 
        $numero_ordini = $dati_sender["ordini_correnti"] - 1;
        $stmt = $this->db->prepare("UPDATE Fattorino SET ordini_correnti = ? WHERE username_fattorino = ?");
        $stmt->bind_param("is", $numero_ordini, $username_sender);
        $stmt->execute();
    }


    //sezione notifiche
    public function getNotification($username){//prende tutte le notifiche dell'utente loggato
        $stmt = $this->db->prepare("SELECT * FROM notifica 
        WHERE username_receiver = ?
        ORDER BY letta ASC, id_notifica DESC"); 
        $stmt->bind_param("s", $username);      
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC); 
    }

    public function getUnreadNumber($username){
        $stmt = $this->db->prepare("SELECT COUNT(id_notifica) as num FROM notifica 
        WHERE username_receiver = ?
        AND letta=0");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);        
    }

    public function markAsRead($username){//segna le notifiche come già lette (non nuove)
        $stmt = $this->db->prepare("UPDATE Notifica SET letta = 1 WHERE username_receiver = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
    }

    public function notifyIfProductIsOutOfStock($username_utente){//verifica i prodotti esauriti al momento dell'ordine e invia le notifiche
        foreach ($this->getAllUserProducts($username_utente) as $prodotto_in_carrello){
            if ($prodotto_in_carrello["quantità_residua"] == 0) {
                //notifica: consegna effettuata
                $testo = "il prodotto ".$prodotto_in_carrello["nome"]." è esaurito.";
                $username_sender = "Comfort Zone";
                $username_receiver = $prodotto_in_carrello["username_venditore"];
                $this->notify($testo, $username_sender, $username_receiver);
            }
        }
    }

    public function requestRestock($id_prodotto, $username_utente){
        $dati_prodotto = ($this->getProductById($id_prodotto))[0];
        $testo = "È stato richiesto un rifornimento del prodotto ".$dati_prodotto["nome"];
        $this->notify($testo, $username_utente, $dati_prodotto["username_venditore"]);
    }

    public function notify($testo, $username_sender, $username_receiver){//invia una notifica
        $stm = $this->db->prepare("INSERT INTO notifica (testo, username_sender, username_receiver, letta) 
        VALUES (?, ?, ?, 0)");
        $stm->bind_param("sss",$testo, $username_sender, $username_receiver);
        $stm->execute();
    }

    //sezione registrazione, login e sicurezza
    public function checkUtente($user, $password, $account){
        if ($account == "Utente"){
            $stmt = $this->db->prepare("SELECT count(*) FROM utente WHERE username_utente=? AND password_utente=? ");
        } if ($account == "Venditore"){
            $stmt = $this->db->prepare("SELECT count(*) FROM venditore WHERE username_venditore=? AND password_venditore=? ");
        } if ($account == "Fattorino"){
            $stmt = $this->db->prepare("SELECT count(*) FROM fattorino WHERE username_fattorino=? AND password_fattorino=? ");
        }
        $stmt->bind_param('ss',$user, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function uniqueUserUtente($user){
        $stmtu = $this->db->prepare("SELECT count(*) FROM utente WHERE username_utente=?");
        $stmtu->bind_param('s',$user);
        $stmtu->execute();
        $resultu = $stmtu->get_result();
        return $resultu->fetch_all(MYSQLI_ASSOC);
    }

    public function uniqueUserVenditore($user){
        $stmtu = $this->db->prepare("SELECT count(*) FROM venditore WHERE username_venditore=?");
        $stmtu->bind_param('s',$user);
        $stmtu->execute();
        $resultu = $stmtu->get_result();
        return $resultu->fetch_all(MYSQLI_ASSOC);
    }

    public function uniqueUserFattorino($user){
        $stmtu = $this->db->prepare("SELECT count(*) FROM fattorino WHERE username_fattorino=?");
        $stmtu->bind_param('s',$user);
        $stmtu->execute();
        $resultu = $stmtu->get_result();
        return $resultu->fetch_all(MYSQLI_ASSOC);
    }

    public function incrementaTentativiUtente($user, $account){
        if ($account == "Utente"){
            $stm = $this->db->prepare("UPDATE utente SET tentativi = tentativi + 1 WHERE username_utente = ?");
        } if ($account == "Venditore"){
            $stm = $this->db->prepare("UPDATE venditore SET tentativi = tentativi + 1 WHERE username_venditore = ?");
        } if ($account == "Fattorino"){
            $stm = $this->db->prepare("UPDATE fattorino SET tentativi = tentativi + 1 WHERE username_fattorino = ?");
        }
        $stm->bind_param("s", $user);
        $stm->execute();
        $result = $stm->get_result();

    }

    public function getTempoAttualeUtente($user, $account){
        if ($account == "Utente"){
            $stm = $this->db->prepare("SELECT tempo_attuale FROM utente WHERE username_utente = ? ");
        } if ($account == "Venditore"){
            $stm = $this->db->prepare("SELECT tempo_attuale FROM venditore WHERE username_venditore = ? ");
        } if ($account == "Fattorino"){
            $stm = $this->db->prepare("SELECT tempo_attuale FROM fattorino WHERE username_fattorino = ? ");
        }
        $stm->bind_param("s", $user);
        $stm->execute();
        $result = $stm->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getTempoDisabilitatoUtente($user, $account){
        if ($account == "Utente"){
            $stm = $this->db->prepare("SELECT tempo_disabilitato FROM utente WHERE username_utente = ? ");
        } if ($account == "Venditore"){
            $stm = $this->db->prepare("SELECT tempo_disabilitato FROM venditore WHERE username_venditore = ? ");
        } if ($account == "Fattorino"){
            $stm = $this->db->prepare("SELECT tempo_disabilitato FROM fattorino WHERE username_fattorino = ? ");
        }
        $stm->bind_param("s", $user);
        $stm->execute();
        $result = $stm->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getTentativiUtente($user, $account){
        if ($account == "Utente"){
            $stm = $this->db->prepare("SELECT tentativi FROM utente WHERE username_utente = ? ");
        } if ($account == "Venditore"){
            $stm = $this->db->prepare("SELECT tentativi FROM venditore WHERE username_venditore = ? ");
        } if ($account == "Fattorino"){
            $stm = $this->db->prepare("SELECT tentativi FROM fattorino WHERE username_fattorino = ? ");
        }
        $stm->bind_param("s", $user);
        $stm->execute();
        $result = $stm->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function setAbilitazioneUtente($abilitato, $user, $account){
        if ($account == "Utente"){
            $stm = $this->db->prepare("UPDATE utente SET abilitato = ? WHERE username_utente = ?");
        } if ($account == "Venditore"){
            $stm = $this->db->prepare("UPDATE venditore SET abilitato = ? WHERE username_venditore = ?");
        } if ($account == "Fattorino"){
            $stm = $this->db->prepare("UPDATE fattorino SET abilitato = ? WHERE username_fattorino = ?");
        }
        $stm->bind_param("is", $abilitato, $user);
        $stm->execute();
        $result = $stm->get_result();
    }

    public function setTentativiUtente($tentativi, $user, $account){
        if ($account == "Utente"){
            $stm = $this->db->prepare("UPDATE utente SET tentativi = ? WHERE username_utente = ?");
        } if ($account == "Venditore"){
            $stm = $this->db->prepare("UPDATE venditore SET tentativi = ? WHERE username_venditore = ?");
        } if ($account == "Fattorino"){
            $stm = $this->db->prepare("UPDATE fattorino SET tentativi = ? WHERE username_fattorino = ?");
        }
        $stm->bind_param("is", $tentativi, $user);
        $stm->execute();
        $result = $stm->get_result();
    }

    public function insertUtente($pagam, $user, $password, $email, $nome, $cognome, $sale){
        $stm = $this->db->prepare("INSERT INTO `utente` (`metodo_pagamento`, `nome_utente`, `cognome_utente`, `username_utente`, `password_utente`, `email_utente`, `sale`) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stm->bind_param("sssssss", $pagam, $nome, $cognome, $user, $password, $email, $sale);
        $stm->execute();
    }

    public function insertVenditore($bankcode, $user, $password, $email, $nome, $sale){
        $stm = $this->db->prepare("INSERT INTO `venditore` (`codice_bancario`, `nome_marchio`, `username_venditore`, `password_venditore`, `email_venditore`, `sale`) VALUES (?, ?, ?, ?, ?, ?)");
        $stm->bind_param("ssssss", $bankcode, $nome, $user, $password, $email, $sale);
        $stm->execute();
    }

    public function insertFattorino($cognome, $user, $password, $email, $nome, $sale){
        $stm = $this->db->prepare("INSERT INTO `fattorino` (`nome_fattorino`, `cognome_fattorino`, `username_fattorino`, `password_fattorino`, `email_fattorino`, `sale`) VALUES (?, ?, ?, ?, ?, ?)");
        $stm->bind_param("ssssss", $nome, $cognome, $user, $password, $email, $sale);
        $stm->execute();
    }
    


    public function setTempoAttualeUtente($user, $tempo, $account){
        if ($account == "Utente"){
            $stm = $this->db->prepare("UPDATE utente SET tempo_attuale = ? WHERE username_utente = ?");
        } if ($account == "Venditore"){
            $stm = $this->db->prepare("UPDATE venditore SET tempo_attuale = ? WHERE username_venditore = ?");
        } if ($account == "Fattorino"){
            $stm = $this->db->prepare("UPDATE fattorino SET tempo_attuale = ? WHERE username_fattorino = ?");
        }
        $stm->bind_param("ss", $tempo, $user);
        $stm->execute();
        $result = $stm->get_result();
    }

    public function setTempoDisabilitatoUtente($user, $tempo, $account){
        if ($account == "Utente"){
            $stm = $this->db->prepare("UPDATE utente SET tempo_disabilitato = ? WHERE username_utente = ?");
        } if ($account == "Venditore"){
            $stm = $this->db->prepare("UPDATE venditore SET tempo_disabilitato = ? WHERE username_venditore = ?");
        } if ($account == "Fattorino"){
            $stm = $this->db->prepare("UPDATE fattorino SET tempo_disabilitato = ? WHERE username_fattorino = ?");
        }
        $stm->bind_param("ss", $tempo, $user);
        $stm->execute();
        $result = $stm->get_result();
    }
    

    public function getSaleUtente($user, $account){
        if ($account == "Utente"){
            $stm = $this->db->prepare("SELECT sale FROM utente WHERE username_utente = ? ");
        } if ($account == "Venditore"){
            $stm = $this->db->prepare("SELECT sale FROM venditore WHERE username_venditore = ? ");
        } if ($account == "Fattorino"){
            $stm = $this->db->prepare("SELECT sale FROM fattorino WHERE username_fattorino = ? ");
        }
        $stm->bind_param("s", $user);
        $stm->execute();
        $result = $stm->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getAbilitatoUtente($user, $account){
        if ($account == "Utente"){
            $stm = $this->db->prepare("SELECT abilitato FROM utente WHERE username_utente = ? ");
        } if ($account == "Venditore"){
            $stm = $this->db->prepare("SELECT abilitato FROM venditore WHERE username_venditore = ? ");
        } if ($account == "Fattorino"){
            $stm = $this->db->prepare("SELECT abilitato FROM fattorino WHERE username_fattorino = ? ");
        }
        $stm->bind_param("s", $user);
        $stm->execute();
        $result = $stm->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }



    public function insertProdotto( $quantità, $prezzo_unitario, $nome, $descrizione, $id_categoria, $username_venditore){
        $stm = $this->db->prepare("INSERT INTO `prodotto` ( `quantità`, `prezzo_unitario`, `nome`, `descrizione`, `id_categoria`,`username_venditore`) VALUES ( ?, ?, ?, ?, ?, ?)");
        $stm->bind_param("idssis", $quantità, $prezzo_unitario, $nome, $descrizione, $id_categoria, $username_venditore);
        $stm->execute();
        return $stm->insert_id;
    }


    public function editDati($nome, $cognome, $password, $email, $user, $pagamento, $account, $marchio, $codice_bancario){
        if($account == "Utente"){
            $stm = $this->db->prepare("UPDATE utente SET nome_utente = ?, cognome_utente = ?, password_utente = ?, email_utente = ?, metodo_pagamento = ? WHERE username_utente = ?");
            $stm->bind_param("ssssss", $nome, $cognome, $password, $email, $pagamento, $user);
            $stm->execute();
            $result = $stm->get_result();
        } 
        if ($account == "Fattorino"){
            $stm = $this->db->prepare("UPDATE fattorino SET nome_fattorino = ?, cognome_fattorino = ?, password_fattorino = ?, email_fattorino = ? WHERE username_fattorino = ?");
            $stm->bind_param("sssss", $nome, $cognome, $password, $email, $user);
            $stm->execute();
            $result = $stm->get_result();
        } 
        if ($account == "Venditore"){
            $stm = $this->db->prepare("UPDATE venditore SET password_venditore = ?, email_venditore = ?, nome_marchio = ?, codice_bancario = ? WHERE username_venditore = ?");
            $stm->bind_param("sssss", $password, $email, $marchio, $codice_bancario, $user);
            $stm->execute();
            $result = $stm->get_result();
        }
    }

    public function getUserInfo($username_utente){
        $stmt = $this->db->prepare("SELECT * FROM utente 
        WHERE username_utente = ?
        LIMIT 1");
        $stmt->bind_param('s', $username_utente);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);        
    }


    
}
?>




