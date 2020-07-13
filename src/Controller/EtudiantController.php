<?php

namespace App\Controller;

use App\Form\EtudiantType;
use App\Entity\Etudiant;
use App\Form\RechercheType;
use App\Entity\Recherche;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\EtudiantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class EtudiantController extends AbstractController
{
    /**
     * @Route("/etudiant", name="etudiant_index")
     */
    public function index(Request $request, EtudiantRepository $etudiantRepository, PaginatorInterface $paginator)
    {
        $donnees = $etudiantRepository->findAll();
        //dd($etudiant);
        $etudiants = $paginator->paginate(
            $donnees,
            $request->query->getInt('page',1),
            5
        );
        return $this->render('etudiant/index.html.twig', compact('etudiants'));
    }

        /**
     * @Route("/etudiant/recherche/boursier", name="etudiant_boursier")
     */
    public function boursier(Request $request, EtudiantRepository $etudiantRepository, PaginatorInterface $paginator)
    {
        $donnees = $etudiantRepository->findByTypeEtudiant('Boursier');
        //dd($etudiant);
        $etudiants = $paginator->paginate(
            $donnees,
            $request->query->getInt('page',1),
            5
        );
        return $this->render('etudiant/index.html.twig', compact('etudiants'));
    }

            /**
     * @Route("/etudiant/recherche/non_boursier", name="etudiant_non_boursier")
     */
    public function nonBoursier(Request $request, EtudiantRepository $etudiantRepository, PaginatorInterface $paginator)
    {
        $donnees = $etudiantRepository->findByTypeEtudiant('Non Boursier');
        //dd($etudiant);
        $etudiants = $paginator->paginate(
            $donnees,
            $request->query->getInt('page',1),
            5
        );
        return $this->render('etudiant/index.html.twig', compact('etudiants'));
    }

            /**
     * @Route("/etudiant/recherche/loger", name="etudiant_loger")
     */
    public function loger(Request $request, EtudiantRepository $etudiantRepository, PaginatorInterface $paginator)
    {
        $donnees = $etudiantRepository->findByTypeEtudiant('Loger');
        //dd($etudiant);
        $etudiants = $paginator->paginate(
            $donnees,
            $request->query->getInt('page',1),
            5
        );
        return $this->render('etudiant/index.html.twig', compact('etudiants'));
    }

    private function genereMatricule($prenom,$nom){
        $nombre = rand(1,9999);
        $nombre = sprintf("%'.04d\n", $nombre);
        $cc="";
        $ll="";
        for ($i=0; $i < 2 ; $i++) { 
            $cc.=$nom[$i];
        }
        for ($j=(strlen($prenom)-2); $j < strlen($prenom) ; $j++) { 
            $ll.=$prenom[$j];
        }
        return $matricule = date("Y")." ".strtoupper($cc)." ".strtoupper($ll)." ".$nombre;
    }

    /**
     * @Route("/etudiant/create", name="etudiant_create", methods={"POST","GET"})
     */
    public function create(Request $request, EntityManagerInterface $em):Response
    {
        $etudiant = new Etudiant();
        $form = $this->createForm(EtudiantType::class,$etudiant);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //GENERER MATRICULE
           $nom = $etudiant->getNom();
           $prenom = $etudiant->getPrenom();
           $matricule = $this->genereMatricule($prenom,$nom);
           $etudiant->setMatricule($matricule);

            $em->persist($etudiant);
            $em->flush();
            return $this->redirectToRoute('etudiant_index');
        }
        return $this->render('etudiant/create.html.twig', [
            'formEtudiant' => $form->createView(),
        ]);
    }

     /**
     * @Route("/etudiant/{id<[0-9]+>}/update", name="etudiant_update", methods={"POST","GET"})
     */
    public function update(Request $request, EntityManagerInterface $em, Etudiant $etudiant):Response
    {
        //$etudiant = new etudiant();
        $form = $this->createForm(EtudiantType::class,$etudiant);
        dump($etudiant);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $nom = $etudiant->getNom();
            $prenom = $etudiant->getPrenom();
            $matricule = $this->genereMatricule($prenom,$nom);
            $etudiant->setMatricule($matricule);
            //$em = $this->getDoctrine()->getManager();
            //$em->persist($etudiant);
            $em->flush();
            return $this->redirectToRoute('etudiant_index');
        }
        return $this->render('etudiant/create.html.twig', [
            'etudiant' => $etudiant,
            'formEtudiant' => $form->createView(),
        ]);
    }

     /**
     * @Route("/etudiant/{id<[0-9]+>}/delete", name="etudiant_delete")
     */
    public function delete(Request $request, EntityManagerInterface $em, Etudiant $etudiant):Response
    {
        $em->remove($etudiant);
        $em->flush();
        return $this->redirectToRoute('etudiant_index');

    }
}