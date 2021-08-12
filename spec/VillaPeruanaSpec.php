<?php

use App\VillaPeruana;
use App\Productos\ProductoBase as Normal;
use App\Productos\PiscoPeruano;
use App\Productos\TicketVip;
use App\Productos\Tumi;
use App\Productos\Cafe;

/*
 * Your work begins on LINE 248.
 */

describe('Villa Peruana', function () {

    describe('#tick', function () {

        context ('productos normales', function () {

            it ('actualiza productos normales antes de la fecha de venta', function () {

                $item = VillaPeruana::of(new Normal(10, 5));// quality, sell in X days

                $item->tick();

                expect($item->product->quality)->toBe(9);
                expect($item->product->sellIn)->toBe(4);
            });

            it ('actualiza productos normales en la fecha de venta', function () {
                $item = VillaPeruana::of(new Normal(10, 0));

                $item->tick();

                expect($item->product->quality)->toBe(8);
                expect($item->product->sellIn)->toBe(-1);
            });

            it ('actualiza productos normales después de la fecha de venta', function () {
                $item = VillaPeruana::of(new Normal(10, -5));

                $item->tick();

                expect($item->product->quality)->toBe(8);
                expect($item->product->sellIn)->toBe(-6);
            });

            it ('actualiza productos normales con calidad 0', function () {
                $item = VillaPeruana::of(new Normal(0, 5));

                $item->tick();

                expect($item->product->quality)->toBe(0);
                expect($item->product->sellIn)->toBe(4);
            });

        });


        context('Pisco Peruano', function () {

            it ('actualiza Pisco Peruano antes de la fecha de venta', function () {
                $item = VillaPeruana::of(new PiscoPeruano(10, 5));

                $item->tick();

                expect($item->product->quality)->toBe(11);
                expect($item->product->sellIn)->toBe(4);
            });

            it ('actualiza Pisco Peruano antes de la fecha de venta con máxima calidad', function () {
                $item = VillaPeruana::of(new PiscoPeruano(50, 5));

                $item->tick();

                expect($item->product->quality)->toBe(50);
                expect($item->product->sellIn)->toBe(4);
            });

            it ('actualiza Pisco Peruano en la fecha de venta', function () {
                $item = VillaPeruana::of(new PiscoPeruano(10, 0));

                $item->tick();

                expect($item->product->quality)->toBe(12);
                expect($item->product->sellIn)->toBe(-1);
            });

            it ('actualiza Pisco Peruano en la fecha de venta, cerca a su máxima calidad', function () {
                $item = VillaPeruana::of(new PiscoPeruano(49, 0));

                $item->tick();

                expect($item->product->quality)->toBe(50);
                expect($item->product->sellIn)->toBe(-1);
            });

            it ('actualiza Pisco Peruano en la fecha de venta con máxima calidad', function () {
                $item = VillaPeruana::of(new PiscoPeruano(50, 0));

                $item->tick();

                expect($item->product->quality)->toBe(50);
                expect($item->product->sellIn)->toBe(-1);
            });

            it ('actualiza Pisco Peruano después de la fecha de venta', function () {
                $item = VillaPeruana::of(new PiscoPeruano(10, -10));

                $item->tick();

                expect($item->product->quality)->toBe(12);
                expect($item->product->sellIn)->toBe(-11);
            });

             it ('actualiza Briem items después de la fecha de venta con máxima calidad', function () {
                $item = VillaPeruana::of(new PiscoPeruano(50, -10));

                $item->tick();

                expect($item->product->quality)->toBe(50);
                expect($item->product->sellIn)->toBe(-11);
            });

        });


        context('Tumi', function () {

            it ('actualiza elementos Tumi antes de la fecha de venta', function () {
                $item = VillaPeruana::of(new Tumi(10, 5));

                $item->tick();

                expect($item->product->quality)->toBe(80);
                expect($item->product->sellIn)->toBe(0);
            });

            it ('actualiza elementos Tumi en la fecha de venta', function () {
                $item = VillaPeruana::of(new Tumi(10, 5));

                $item->tick();

                expect($item->product->quality)->toBe(80);
                expect($item->product->sellIn)->toBe(0);
            });

            it ('actualiza elementos Tumi después de la fecha de venta', function () {
                $item = VillaPeruana::of(new Tumi(10, -1));

                $item->tick();

                expect($item->product->quality)->toBe(80);
                expect($item->product->sellIn)->toBe(0);
            });

        });


        context('Tickets VIP', function () {
            /*
                "Backstage passes", like Pisco Peruano, increases in Quality as it's SellIn
                value approaches; Quality increases by 2 when there are 10 days or
                less and by 3 when there are 5 days or less but Quality drops to
                0 after the concert
             */
            it ('actualiza tickets VIP antes de la fecha del evento', function () {
                $item = VillaPeruana::of(new TicketVip(10, 11));

                $item->tick();

                expect($item->product->quality)->toBe(11);
                expect($item->product->sellIn)->toBe(10);
            });

            it ('actualiza tickets VIP cerca a la fecha del evento', function () {
                $item = VillaPeruana::of(new TicketVip(10, 10));

                $item->tick();

                expect($item->product->quality)->toBe(12);
                expect($item->product->sellIn)->toBe(9);
            });

            it ('actualiza tickets VIP cerca a la fecha del evento, a la mayor calidad', function () {
                $item = VillaPeruana::of(new TicketVip(50, 10));

                $item->tick();

                expect($item->product->quality)->toBe(50);
                expect($item->product->sellIn)->toBe(9);
            });

            it ('actualiza tickets VIP muy cerca a la fecha del evento', function () {
                $item = VillaPeruana::of(new TicketVip(10, 5));

                $item->tick();

                expect($item->product->quality)->toBe(13); // goes up by 3
                expect($item->product->sellIn)->toBe(4);
            });

            it ('actualiza tickets VIP muy cerca a la fecha del evento, a máxima calidad', function () {
                $item = VillaPeruana::of(new TicketVip(50, 5));

                $item->tick();

                expect($item->product->quality)->toBe(50);
                expect($item->product->sellIn)->toBe(4);
            });

            it ('actualiza tickets VIP un día antes de la fecha del evento', function () {
                $item = VillaPeruana::of(new TicketVip(10, 1));

                $item->tick();

                expect($item->product->quality)->toBe(13);
                expect($item->product->sellIn)->toBe(0);
            });

            it ('actualiza tickets VIP un día antes de la fecha del evento, a calidad máxima', function () {

                $item = VillaPeruana::of(new TicketVip(50, 1));

                $item->tick();

                expect($item->product->quality)->toBe(50);
                expect($item->product->sellIn)->toBe(0);
            });

            it ('actualiza tickets VIP en la fecha del evento', function () {

                $item = VillaPeruana::of(new TicketVip(10, 0));

                $item->tick();

                expect($item->product->quality)->toBe(0);
                expect($item->product->sellIn)->toBe(-1);
            });

            it ('actualiza tickets VIP después de la fecha del evento', function () {

                $item = VillaPeruana::of(new TicketVip(10, -1));

                $item->tick();

                expect($item->product->quality)->toBe(0);
                expect($item->product->sellIn)->toBe(-2);
            });

        });


        context ("Producto de Café", function () {

            it ('actualiza Producto de Café antes de la fecha de venta', function () {
                $item = VillaPeruana::of(new Cafe(10, 10));

                $item->tick();

                expect($item->product->quality)->toBe(8);
                expect($item->product->sellIn)->toBe(9);
            });

            it ('actualiza Producto de Café con cualidad 0', function () {
                $item = VillaPeruana::of(new Cafe(0, 10));

                $item->tick();

                expect($item->product->quality)->toBe(0);
                expect($item->product->sellIn)->toBe(9);
            });

            it ('actualiza Producto de Café en la fecha de venta', function () {
                $item = VillaPeruana::of(new Cafe(10, 0));

                $item->tick();

                expect($item->product->quality)->toBe(6);
                expect($item->product->sellIn)->toBe(-1);
            });

            it ('actualiza Producto de Café en la fecha de venta con calidad 0', function () {
                $item = VillaPeruana::of(new Cafe(0, 0));

                $item->tick();

                expect($item->product->quality)->toBe(0);
                expect($item->product->sellIn)->toBe(-1);
            });

            it ('actualiza Producto de Café después de la fecha de venta', function () {
                $item = VillaPeruana::of(new Cafe(10, -10));

                $item->tick();

                expect($item->product->quality)->toBe(6);
                expect($item->product->sellIn)->toBe(-11);
            });

            it ('actualiza Producto de Café después de la fecha de venta con calidad 0', function () {
                $item = VillaPeruana::of(new Cafe(0, -10));

                $item->tick();

                expect($item->product->quality)->toBe(0);
                expect($item->product->sellIn)->toBe(-11);
            });

        });

    });

});
