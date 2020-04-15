<?php
/**
 * SellType file
 *
 * PHP version 7
 *
 * @category Type
 *
 * @package App\Form\Type
 *
 * @author Faysal Ahmed <faysal.ahmed833@gmail.com>
 *
 * @license custom license http://www.eskimi.com/
 *
 * @link http://www.eskimi.com/
 */

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * SellType Class
 *
 * PHP version 7
 *
 * @category Type
 *
 * @package App\Form\Type
 *
 * @author Faysal Ahmed <faysal.ahmed833@gmail.com>
 *
 * @license custom license http://www.eskimi.com/
 *
 * @link http://www.eskimi.com/
 */
class SellType extends AbstractType
{
    /**
     * Build Form function
     *
     * @param FormBuilderInterface $builder builder
     * @param array                $options options for buildForm
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('quantity', NumberType::class)
            ->add('price', NumberType::class)
            ->add('save', SubmitType::class, ['label' => 'Add Sell']);
    }
}
