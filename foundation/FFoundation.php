<?php

abstract class FFoundation
{
    public static function getEntityManager()
    {
        return FEntityManager::getInstance();
    }
}
