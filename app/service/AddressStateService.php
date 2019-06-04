<?php

namespace App\Services;

use App\Models\AddressState;

class AddressStateService
{
    /**
     * Retorna o estado referente o id passado
     *
     * @param $id
     * @return mixed
     */
    public static function getById($id)
    {
        return AddressState::find($id);
    }

    /**
     * Retorna o estado de acordo com as iniciais.
     * Opcionalmente, este método poderá retornar junto ao estado, todas as suas cidades
     *
     * @param $initials
     * @param bool $withCities
     * @return mixed
     */
    public static function getByInitials($initials, $withCities = false)
    {
        $builder = AddressState::where('initials', $initials)
            ->orderBy('name', 'DESC');

        // verifica se foi solicitado as cidades do estado
        if ($withCities) {
            // adiciona na query as cidades
            $builder->with('cities:city_id,name,state_id');
        }

        return $builder->first();
    }

    /**
     * Retorna todos os estados (ordenado pelas siglas)
     *
     * @return mixed
     */
    public static function getAll()
    {
        return AddressState::select('state_id', 'name', 'initials')
            ->orderBy('initials')
            ->get();
    }
}
