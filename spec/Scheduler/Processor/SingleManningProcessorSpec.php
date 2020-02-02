<?php

namespace spec\Scheduler\Processor;

use PhpSpec\ObjectBehavior;
use Psr\Log\LoggerInterface;
use Scheduler\Entity\Interfaces\RotaInterface;
use Scheduler\Entity\Interfaces\ShiftInterface;
use Scheduler\Entity\Interfaces\SingleManningInterface;
use Scheduler\Repository\ShiftBreakRepository;
use Scheduler\Repository\ShiftRepository;

class SingleManningProcessorSpec extends ObjectBehavior
{
    public function let(
        LoggerInterface $logger,
        ShiftRepository $shiftRepository,
        ShiftBreakRepository $shiftBreakRepository,
        RotaInterface $rota
    ) {
        $rota->getRotaID()->willReturn(1);
        $this->beConstructedWith($logger, $shiftRepository, $shiftBreakRepository);
    }

    /**
     * Scenario 1:
     *
     * Given: Black Widow working at FunHouse on Monday in one long shift
     * When: no-one else works during the day
     * Then: Black Widow receives single manning supplement for the whole duration of her shift.
     */
    public function it_should_calculate_single_manning_objects_from_rota_scenario_1(
        ShiftRepository $shiftRepository,
        ShiftInterface $shift,
        RotaInterface $rota
    ) {
        // Given
        $shift->getShiftID()->willReturn(1);
        $shift->getStaffID()->willReturn(1); // Black Widow Staff ID
        $shift->getStartTime()->willReturn(new \DateTimeImmutable('2020-01-27 09:00'));
        $shift->getEndTime()->willReturn(new \DateTimeImmutable('2020-01-27 17:30'));

        // Promises
        $shiftRepository->fetchByRotaID(1)->willReturn([$shift]);

        // When / Then
        $this->calculateMinutes($rota)->shouldReturnScenarioOneResults();
    }

    /**
     * Scenario 2:
     *
     * Given: Black Widow and Thor working at FunHouse on Tuesday
     * When: they only meet at the door to say hi and bye
     * Then: Black Widow receives single manning supplement for the whole duration of her shift
     * And: Thor also receives single manning supplement for the whole duration of his shift.
     */
    public function it_should_calculate_single_manning_objects_from_rota_scenario_2(
        ShiftRepository $shiftRepository,
        ShiftInterface $blackWidowShift,
        ShiftInterface $thorShift,
        RotaInterface $rota
    ) {
        // Given
        $blackWidowShift->getShiftID()->willReturn(2);
        $blackWidowShift->getStaffID()->willReturn(1); // Black Widow Staff ID
        $blackWidowShift->getStartTime()->willReturn(new \DateTimeImmutable('2020-01-28 09:00'));
        $blackWidowShift->getEndTime()->willReturn(new \DateTimeImmutable('2020-01-28 13:00'));

        $thorShift->getShiftID()->willReturn(3);
        $thorShift->getStaffID()->willReturn(2); // Thor Staff ID
        $thorShift->getStartTime()->willReturn(new \DateTimeImmutable('2020-01-28 13:00'));
        $thorShift->getEndTime()->willReturn(new \DateTimeImmutable('2020-01-28 17:30'));

        // Promises
        $shiftRepository->fetchByRotaID(1)->willReturn([$blackWidowShift, $thorShift]);

        // When / Then
        $this->calculateMinutes($rota)->shouldReturnScenarioTwoResults();
    }

    /**
     * Scenario 3
     *
     * Given: Wolverine and Gamora working at FunHouse on Wednesday
     * When: Wolverine works in the morning shift
     * And: Gamora works the whole day, starting slightly later than Wolverine
     * Then: Wolverine receives single manning supplement until Gamora starts her shift
     * And: Gamora receives single manning supplement starting when Wolverine has finished his shift, until the end of the day.
     */
    public function it_should_calculate_single_manning_objects_from_rota_scenario_3(
        ShiftRepository $shiftRepository,
        ShiftInterface $wolverineShift,
        ShiftInterface $gamoraShift,
        RotaInterface $rota
    ) {
        // Given
        $wolverineShift->getShiftID()->willReturn(4);
        $wolverineShift->getStaffID()->willReturn(3);
        $wolverineShift->getStartTime()->willReturn(new \DateTimeImmutable('2020-01-29 09:00'));
        $wolverineShift->getEndTime()->willReturn(new \DateTimeImmutable('2020-01-29 13:00'));

        $gamoraShift->getShiftID()->willReturn(5);
        $gamoraShift->getStaffID()->willReturn(4); // Gamora Staff ID
        $gamoraShift->getStartTime()->willReturn(new \DateTimeImmutable('2020-01-29 10:00'));
        $gamoraShift->getEndTime()->willReturn(new \DateTimeImmutable('2020-01-29 17:30'));

        // Promises
        $shiftRepository->fetchByRotaID(1)->willReturn([$wolverineShift, $gamoraShift]);

        // When / Then
        $this->calculateMinutes($rota)->shouldReturnScenarioThreeResults();
    }

    /**
     * Scenario 4:
     *
     * Given: Black Widow and Gamora are working at FunHouse on Thursday
     * When: Black Widow works the full day (9am - 5:30pm)
     * And: Gamora works during the peak shift (10am - 2pm)
     * Then: Black Widow receives single manning supplement for both before and after Gamora's shift.
     */
    public function it_should_calculate_single_manning_objects_from_rota_scenario_4(
        ShiftRepository $shiftRepository,
        ShiftInterface $blackWidowShift,
        ShiftInterface $gamoraShift,
        RotaInterface $rota
    ) {
        // Given
        $blackWidowShift->getShiftID()->willReturn(6);
        $blackWidowShift->getStaffID()->willReturn(1); // Black Widow Staff ID
        $blackWidowShift->getStartTime()->willReturn(new \DateTimeImmutable('2020-01-30 09:00'));
        $blackWidowShift->getEndTime()->willReturn(new \DateTimeImmutable('2020-01-30 17:30'));

        $gamoraShift->getShiftID()->willReturn(7);
        $gamoraShift->getStaffID()->willReturn(4); // Gamora Staff ID
        $gamoraShift->getStartTime()->willReturn(new \DateTimeImmutable('2020-01-30 10:00'));
        $gamoraShift->getEndTime()->willReturn(new \DateTimeImmutable('2020-01-30 14:00'));

        // Promises
        $shiftRepository->fetchByRotaID(1)->willReturn([$blackWidowShift, $gamoraShift]);

        // When / Then
        $this->calculateMinutes($rota)->shouldReturnScenarioFourResults();
    }

    public function getMatchers(): array
    {
        return [
            'returnScenarioOneResults' => function (array $singleMannings): bool
            {
                // Should be only one result
                if (count($singleMannings) !== 1) {
                    return false;
                }

                foreach ($singleMannings as $singleManning) {
                    if (!$singleManning instanceof SingleManningInterface) {
                        return false;
                    }

                    if ($singleManning->getRotaID() !== 1) {
                        return false;
                    }

                    // Black Widow
                    if ($singleManning->getStaffID() === 1 && $singleManning->getSingleManningMinutes() !== 510) {
                        return false;
                    }
                }

                return true;
            },
            'returnScenarioTwoResults' => function (array $singleMannings): bool
            {
                if (count($singleMannings) !== 2) {
                    return false;
                }

                foreach ($singleMannings as $singleManning) {
                    if (!$singleManning instanceof SingleManningInterface) {
                        return false;
                    }

                    if ($singleManning->getRotaID() !== 1) {
                        return false;
                    }

                    // Black Widow
                    if ($singleManning->getStaffID() === 1 && $singleManning->getSingleManningMinutes() !== 240) {
                        return false;
                    }

                    // Thor
                    if ($singleManning->getStaffID() === 2 && $singleManning->getSingleManningMinutes() !== 270) {
                        return false;
                    }
                }

                return true;
            },
            'returnScenarioThreeResults' => function (array $singleMannings): bool
            {
                if (count($singleMannings) !== 2) {
                    return false;
                }

                foreach ($singleMannings as $singleManning) {
                    if (!$singleManning instanceof SingleManningInterface) {
                        return false;
                    }

                    if ($singleManning->getRotaID() !== 1) {
                        return false;
                    }

                    // Wolverine
                    if ($singleManning->getStaffID() === 3 && $singleManning->getSingleManningMinutes() !== 60) {
                        return false;
                    }

                    // Gamora
                    if ($singleManning->getStaffID() === 4 && $singleManning->getSingleManningMinutes() !== 270) {
                        return false;
                    }
                }

                return true;
            },
            'returnScenarioFourResults' => function (array $singleMannings): bool
            {
                // Should be only one result
                if (count($singleMannings) !== 1) {
                    return false;
                }

                foreach ($singleMannings as $singleManning) {
                    if (!$singleManning instanceof SingleManningInterface) {
                        return false;
                    }

                    if ($singleManning->getRotaID() !== 1) {
                        return false;
                    }

                    // Black Widow
                    if ($singleManning->getStaffID() === 1 && $singleManning->getSingleManningMinutes() !== 270) {
                        return false;
                    }
                }

                return true;
            }
        ];
    }
}