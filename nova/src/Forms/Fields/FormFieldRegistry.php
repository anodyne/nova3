<?php

declare(strict_types=1);

namespace Nova\Forms\Fields;

class FormFieldRegistry
{
    /**
     * @return list<Field>
     */
    public static function fields(): array
    {
        return [
            ShortTextField::make(ShortTextField::component),
            LongTextField::make(LongTextField::component),
            NumberField::make(NumberField::component),
            EmailField::make(EmailField::component),
            DateField::make(DateField::component),
            DropdownField::make(DropdownField::component),
            SelectOneField::make(SelectOneField::component),
            KeyValueField::make(KeyValueField::component),
            ContentField::make(ContentField::component),
        ];
    }
}
