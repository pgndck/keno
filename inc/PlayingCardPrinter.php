<?php


namespace Keno;

use setasign\Fpdi\Fpdi;

require __DIR__ . '/../vendor/setasign/fpdf/makefont/makefont.php';

class PlayingCardPrinter
{
    const PDF_TEMPLATE = __DIR__ . '/../templates/lotto.pdf';
    const FILENAME = 'lotto_ready.pdf';

    private int   $cardsAmount;
    private array $cards;

    public function __construct($cardsAmount)
    {
        $this->cards = [];
        $this->cardsAmount = $cardsAmount;

        for ($cardNumber = 1; $cardNumber <= $cardsAmount; $cardNumber++) {
            $this->cards[$cardNumber] = new PlayingCard($cardNumber);
        }
    }

    public function print()
    {
        $this->printPDF($this->getCards());
    }

    private function printPDF(array $cards)
    {
        $cardsSets = $this->getCardSets($cards);
        $pagesAmount = count($cardsSets);

        $pdf = new FPDI();
        $pdf->setSourceFile(self::PDF_TEMPLATE);
        $pdf->AddFont('crayon', '', 'crayon.php'); //Regular
        $pdf->SetFont('crayon', '', 35);
        $pdf->SetTextColor(40, 40, 40);
        $pdf->SetDisplayMode('real', 'default');

        for ($pageNumber = 0; $pageNumber < $pagesAmount; $pageNumber++) {
            $pdf->addPage();
            $template = $pdf->importPage(1);
            $pdf->useTemplate($template);

            $xStart = 14;
            $yStart = 39;
            $offset = 20;

            $cardOffset = 97;

            foreach ($cardsSets[$pageNumber] as $cardNumber => $card) {
                foreach (range(0, PlayingCard::ROWS - 1) as $row) {
                    foreach (range(0, PlayingCard::COLUMNS - 1) as $column) {
                        $pdf->SetXY($xStart + $offset * $column, $yStart + $offset * $row + $cardOffset * $cardNumber);
                        $pdf->MultiCell(22, 0, $card->getField()[$row][$column], false, 'C');
                    }
                }
            }
        }

        $pdf->Output('I', FILENAME);
    }

    public function getCardSets(array $cards)
    {
        $cardsSets = [];

        while ($cards) {
            $page = [];
            foreach (range(1, 3) as $iterator) {
                if ($cards) {
                    $page[] = array_pop($cards);
                }
            }

            $cardsSets[] = $page;
        }

        return $cardsSets;
    }

    /**
     * @return array
     */
    public function getCards(): array
    {
        return $this->cards;
    }

    /**
     * @return int
     */
    public function getCardsAmount(): int
    {
        return $this->cardsAmount;
    }

    private function printDebug(PlayingCard $card): void
    {
        ?>

        <div class="playing_card">
            <?= "Card Number: " . $card->getCardNumber() ?>
            <pre>
            <?php foreach ($card->getField() as $row) {
                echo "<p>";
                foreach ($row as $number) {
                    echo $number ? '[' . sprintf("%02d", $number) . ']' : '[  ]';
//                    echo " ";
                }
                echo "</p>";
            }; ?>
            </pre>
        </div>

        <?php
    }
}