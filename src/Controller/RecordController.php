<?php

namespace App\Controller;

use App\Entity\Artist;
use App\Entity\Record;
use App\Repository\ArtistRepository;
use App\Repository\RecordRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class RecordController extends AbstractController
{
    /**
     * Liste des artistes
     * @Route("/artist", name="artist_list")
     */
    public function index(ArtistRepository $repository)
    {

        return $this->render('record/artist_list.html.twig', [
            'artist_list' => $repository->findAll(),
        ]);
    }
    /**
     * Page d'un artiste
     * @Route ("/artist/{id}", name="artist_page")
     */
    public function artistPage(Artist $artist)
    {
        return $this->render('record/artist_page.html.twig', [
           'artist' => $artist
        ]);
    }

    /**
     * Page d'un album
     * @Route("/recors/{id}", name="record_page")
     */
    public function recordPage(Record $record)
    {
        return $this->render('record/record_page.html.twig', [
           'record'=> $record
        ]);
    }

    /**
     * Nouveau albums
     * @Route("/news", name="record_news")
     */
    public function recordNews(RecordRepository $repository)
    {
       return $this->render('record/record_news.html.twig', [
           'record_news' =>$repository->findNews(),

       ]);
    }




}
