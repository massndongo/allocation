<?php

namespace App\Controller;

use App\Form\ChambreType;
use App\Entity\Chambre;
use App\Entity\Batiment;
use App\Form\BatimentType;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\ChambreRepository;
use App\Repository\EtudiantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ChambreController extends AbstractController
{
    /**
     * @Route("/chambre", name="chambre_index")
     */
    public function index(Request $request,ChambreRepository $chambreRepository, PaginatorInterface $paginator)
    {
        $donnees = $chambreRepository->findByStatut(1);
        $occupe = "";
        //dd($chambre);
        $chambres = $paginator->paginate(
            $donnees,
            $request->query->getInt('page',1),
            5
        );
        return $this->render('chambre/index.html.twig', compact('chambres','occupe'));
    }

    public function generateur($num){
        if (preg_match("#[0-9]{4}#", $num)) {
            $num +=1;
            return "-".$num;
        }else {
            $num +=1;
            $newN = (string)$num;
            $long = strlen($newN);
            if ($long<4) {
                $num = sprintf("%'.04d\n", $num);
                return "-".$num;
            }
        }
    }

    public function generatorNum($num, $num1){
        $num1 = sprintf("%'.03d\n", $num1);
        $num = $this->generateur($num);
        return $num1."".$num;
    }

    /**
     * @Route("/chambre/create", name="chambre_create", methods={"POST","GET"})
     */
    public function create(ChambreRepository $repo,Request $request, EntityManagerInterface $em):Response
    {
        $chambres = $repo->findAll();
        $nbr = count($chambres);
        $chambre = new Chambre();
        $form = $this->createForm(ChambreType::class,$chambre);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $numB = $chambre->getNumBatiment()->getId();
            dd($numB);
            $numGenere = $this->generatorNum($nbr+1,$numB);
            $chambre->setNumChambre($numGenere);
            $chambre->setStatut(1);

            $em->persist($chambre);
            $em->flush();
            return $this->redirectToRoute('chambre_index');

        }
        return $this->render('chambre/create.html.twig', [
            'formChambre' => $form->createView(),
        ]);
    }

    /**
     * @Route("/batiment/create", name="batiment_create", methods={"POST","GET"})
     */
    public function createb(Request $request, EntityManagerInterface $em):Response
    {
        $batiment = new Batiment();
        $form = $this->createForm(BatimentType::class,$batiment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $message = "Enregistrement";
            $em->persist($batiment);
            $em->flush();
            return $this->render('chambre/createb.html.twig', [
                'formBatiment' => $form->createView(),
                'message' => $message,
            ]);
        }
        $message = "";
        return $this->render('chambre/createb.html.twig', [
            'formBatiment' => $form->createView(),
            'message' => $message,
        ]);
    }

    /**
     * @Route("/chambre/{id<[0-9]+>}/update", name="chambre_update", methods={"POST","GET"})
     */
    public function update(ChambreRepository $repo, Request $request, EntityManagerInterface $em, Chambre $chambre):Response
    {
        $chambres = $repo->findAll();
        $nbr = count($chambres);
        //$chambre = new Chambre();
        $form = $this->createForm(ChambreType::class,$chambre);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $numB = $chambre->getNumBatiment()->getId();
            $numGenere = $this->generatorNum($nbr+1,$numB);
            $chambre->setNumChambre($numGenere);
            $chambre->setStatut(1);

            $em->flush();
            return $this->redirectToRoute('chambre_index');
        }
        return $this->render('chambre/create.html.twig', [
            'chambre' => $chambre,
            'formChambre' => $form->createView(),
        ]);
    }


    /**
     * @Route("/chambre/{id<[0-9]+>}/delete", name="chambre_delete")
     */
    public function delete(Request $request,ChambreRepository $chambreRepository, EtudiantRepository $etudiantRepository, EntityManagerInterface $em, Chambre $chambre, PaginatorInterface $paginator):Response
    {
        $id = $chambre->getId();
        $occupe = $etudiantRepository->findByChambre($id);
        if(!$occupe){
            $chambre->setStatut(0);
            $em->flush();
            return $this->redirectToRoute('chambre_index');
        }else {
            $donnees = $chambreRepository->findByStatut(1);
            //dd($chambre);
            $chambres = $paginator->paginate(
                $donnees,
                $request->query->getInt('page',1),
                5
            );
            return $this->render('chambre/index.html.twig', [
                'chambres' => $chambres,
                'occupe' => $occupe,
                'chambre' => $chambre
            ]);
        }

    }
}
