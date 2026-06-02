<?php

class CWatchlist
{
    public function aggiungi()
    {
        if (!isset($_GET['id']) || empty($_GET['id'])) {
            header("Location: index.php");
            exit();
        }
        $idContenuto = (int)$_GET['id'];

        $userId = Session::get('user_id');

        if (!$userId) {
            $utenti = FUtente::findAll();
            if (!empty($utenti)) {
                $utente = $utenti[0];
            } else {
                $utente = FUtente::register("Mario", "Rossi", "foto.jpg", "mario_rossi", "mario@watchit.it", "password123");
            }
            $userId = $utente->getId();
            Session::set('user_id', $userId);
        } else {
            $utente = FUtente::findById($userId);
        }

        $watchlists = FWatchlist::findByUtente($userId);

        if (empty($watchlists)) {
            $watchlist = new EWatchlist(
                0,
                "La mia Watchlist",
                "La mia watchlist personale creata automaticamente.",
                [],
                Privacy::privato,
                $utente
            );
            FWatchlist::insert($watchlist);
            $idWatchlist = $watchlist->getId();
        } else {
            $idWatchlist = $watchlists[0]->getId();
        }

        if (FWatchlist::contains($idWatchlist, $idContenuto)) {
            FWatchlist::removeContenuto($idWatchlist, $idContenuto);
        } else {
            FWatchlist::addContenuto($idWatchlist, $idContenuto);
        }

        header("Location: index.php");
        exit();
    }
}
