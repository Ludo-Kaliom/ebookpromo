<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Repository\TypeRepository;
use App\Repository\CommentRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MostcommentedController extends AbstractController
{
    #[Route('/mostcommented', name: 'mostcommented')]
    public function mostcommented(TypeRepository $typeRepository, CommentRepository $commentRepository): Response
    {
        $types = $$typeRepository->findAll();
        $comment = $commentRepository->findMostCommented();
        dd($comment);

        return $this->render('mostcommented/mostcommented.html.twig', [
            'controller_name' => 'MostcommentedController',
            'types' => $types,
        ]);
    }
}

//  /**
//   * @param Itinerary $other
//   * @return bool
//   */
//   public function sameValueAs(Itinerary $other) : bool
//   {
//       //We use doctrine's ArrayCollection only to ease comparison
//       //If Legs would be stored in an ArrayCollection hole the time
//       //Itinerary itself would not be immutable,
//       //cause a client could call $itinerary->legs()->add($anotherLeg);
//       //Keeping ValueObjects immutable is a rule of thumb
//       $myLegs = new ArrayCollection($this->legs());
//       $otherLegs = new ArrayCollection($other->legs());
//       if ($myLegs->count() !== $otherLegs->count()) {
//           return false;
//       }
//       return $myLegs->forAll(function ($index, Leg $leg) use($otherLegs) {
//           return $otherLegs->exists(function ($otherIndex, Leg $otherLeg) use($leg) {
//               return $otherLeg->sameValueAs($leg);
//           });
//       });
//   }