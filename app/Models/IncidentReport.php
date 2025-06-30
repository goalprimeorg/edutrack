<?php

namespace App\Models;

class IncidentReport extends AbstractModel
{
    public function school()
    {
        return $this->belongsTo(School::class, 'school_id');
    }

    public function incidentType()
    {
        return $this->belongsTo(IncidentType::class, 'incident_type_id');
    }
}
