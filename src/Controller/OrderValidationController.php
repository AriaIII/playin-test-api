<?php

namespace App\Controller;

use App\Entity\Association;
use App\Manager\AssociationManager;
use App\Manager\DepositEntryManager;
use App\Repository\DepositEntryRepository;
use App\Repository\OrderEntryRepository;
use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class OrderValidationController extends AbstractController
{
    public function __invoke(
        $id,
        Request $request,
        OrderRepository $orderRepository,
        OrderEntryRepository $orderEntryRepository,
        DepositEntryRepository $depositEntryRepository,
        AssociationManager $associationManager,
        DepositEntryManager $depositEntryManager,
        StockEntryRepository $stockEntryRepository,
    ) {
//        dump(json_decode($request->getContent(), true)); die();
        if (json_decode($request->getContent() === true)) {

        }
        $order = $orderRepository->find($id);
        $orderEntries = $orderEntryRepository->findBy(['order' => $id]);
        foreach ($orderEntries as $orderEntry) {
            $orderEntryId = $orderEntry->getId();
            $productId = $orderEntry->getProduct()->getId();
            $orderQuantity = $orderEntry->getQuantity();
            $sellPrice = $orderEntry->getSellPrice();
            $depositEntries = $depositEntryRepository->getDepositEntries($productId);
            if (!empty($depositEntries)) {
                /* ce qu'il faut faire :
                récupérer la quantité
                -> si elle est suffisante pour couvrir la commande :
                    la mettre à jour ou supprimer l'entrée si il n'y a plus de produit
                -> si elle n'est pas suffisante :
                    supprimer l'entrée,
                    récupérer le dépôt suivant et refaire la même chose
                    si plus de dépot : aller chercher le stock
                 */
                foreach ($depositEntries as $depositEntry) {
                    $soldQuantity = $depositEntry->getSoldQuantity();
                    $availableQuantity = $depositEntry->getQuantity() - $soldQuantity;
                    $percentage = $depositEntry->getReimbursementPercentage();
                    if ($availableQuantity >= $orderQuantity) {
                        $margin = $associationManager->depositMarginCaculate($percentage, $sellPrice, $orderQuantity);
                        $associationManager->create($margin, $orderEntryId, Association::DEPOSIT, $depositEntry->getDeposit->getId());
                        $soldQuantity += $orderQuantity;
                        $depositEntryManager->soldQuantityUpdate($depositEntry, $soldQuantity);
                        break;
                    }

                    if ($availableQuantity === $orderQuantity) {
                        $margin = $associationManager->depositMarginCaculate($percentage, $sellPrice, $orderQuantity);
                        $associationManager->create($margin, $orderEntryId, Association::DEPOSIT, $depositEntry->getDeposit->getId());
                        $depositEntryRepository->remove($depositEntry);
                        break;
                    }

                    $margin = $associationManager->depositMarginCaculate($percentage, $sellPrice, $availableQuantity);
                    $associationManager->create($margin, $orderEntryId, Association::DEPOSIT, $depositEntry->getDeposit->getId());
                    $orderQuantity -= $availableQuantity;
                }
            }
            $stockEntries = $stockEntryRepository->getStockEntries($productId);


        } 
    }

}
