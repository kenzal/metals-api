<?php

namespace Kenzal\MetalsApi\Symbols;

use Kenzal\MetalsApi\Contracts\SymbolInterface;
use Kenzal\MetalsApi\Traits\SymbolFunctions;

enum Metal: string implements SymbolInterface
{
    use SymbolFunctions;

    case ALU = "ALU"; // Aluminum
    case ANTIMONY = "ANTIMONY"; // Antimony
    case BITUMEN = "BITUMEN"; // Bitumen
    case BRASS = "BRASS"; // Brass
    case BRONZE = "BRONZE"; // Bronze
    case GALLIUM = "GALLIUM"; // Gallium
    case INDIUM = "INDIUM"; // Indium
    case IRD = "IRD"; // Iridium (Troy Ounce)
    case IRON = "IRON"; // Iron Ore
    case LBXAG = "LBXAG"; // LBMA Silver
    case LBXAUAM = "LBXAUAM"; // LBMA Gold Am
    case LBXAUPM = "LBXAUPM"; // LBMA Gold Pm
    case LBXPDAM = "LBXPDAM"; // LBMA Palladium Am
    case LBXPDPM = "LBXPDPM"; // LBMA Palladium Pm
    case LBXPTAM = "LBXPTAM"; // LBMA Platinum Am
    case LBXPTPM = "LBXPTPM"; // LBMA Platinum Pm
    case LCO = "LCO"; // Cobalt (Troy Ounce)
    case LEAD = "LEAD"; // Lead
    case LITHIUM = "LITHIUM"; // Lithium
    case LME_ALU = "LME-ALU"; // LME Aluminium
    case LME_LEAD = "LME-LEAD"; // LME Lead
    case LME_NI = "LME-NI"; // LME Nickel
    case LME_TIN = "LME-TIN"; // LME Tin
    case LME_XCU = "LME-XCU"; // LME Copper
    case LME_ZNC = "LME-ZNC"; // LME Zinc
    case MG = "MG"; // Magnesium
    case MN = "MN"; // Manganese
    case MO = "MO"; // Molybdenum
    case ND = "ND"; // Neodymium
    case NI = "NI"; // Nickel
    case OSMIUM = "OSMIUM"; // Osmium
    case RHENIUM = "RHENIUM"; // Rhenium
    case RUTH = "RUTH"; // Ruthenium
    case STEEL_HR = "STEEL-HR"; // LME Steel HRC FOB China
    case STEEL_RE = "STEEL-RE"; // LME Steel Rebar FOB Turkey
    case STEEL_SC = "STEEL-SC"; // LME Steel Scrap CFR Turkey
    case TE = "TE"; // Tellurium
    case TIN = "TIN"; // Tin
    case TUNGSTEN = "TUNGSTEN"; // Tungsten
    case URANIUM = "URANIUM"; // Uranium
    case XAG_AHME = "XAG-AHME"; // Ahmedabad Silver
    case XAG_BANG = "XAG-BANG"; // Bangalore Silver
    case XAG_CHEN = "XAG-CHEN"; // Chennai Silver
    case XAG_COIM = "XAG-COIM"; // Coimbatore Silver
    case XAG_DELH = "XAG-DELH"; // Delhi Silver
    case XAG_HYDE = "XAG-HYDE"; // Hyderabad Silver
    case XAG_KOCH = "XAG-KOCH"; // Kochi Silver
    case XAG_KOLK = "XAG-KOLK"; // Kolkata Silver
    case XAG_MUMB = "XAG-MUMB"; // Mumbai Silver
    case XAG_SURA = "XAG-SURA"; // Surat Silver
    case XAG = "XAG"; // Silver (Troy Ounce)
    case XAU_AHME = "XAU-AHME"; // Ahmedabad Gold
    case XAU_BANG = "XAU-BANG"; // Bangalore Gold
    case XAU_CHEN = "XAU-CHEN"; // Chennai Gold
    case XAU_COIM = "XAU-COIM"; // Coimbatore Gold
    case XAU_DELH = "XAU-DELH"; // Delhi Gold
    case XAU_HYDE = "XAU-HYDE"; // Hyderabad Gold
    case XAU_KOCH = "XAU-KOCH"; // Kochi Gold
    case XAU_KOLK = "XAU-KOLK"; // Kolkata Gold
    case XAU_MUMB = "XAU-MUMB"; // Mumbai Gold
    case XAU_SURA = "XAU-SURA"; // Surat Gold
    case XAU = "XAU"; // Gold (Troy Ounce)
    case XCU = "XCU"; // Copper
    case XPD = "XPD"; // Palladium (Troy Ounce)
    case XPT = "XPT"; // Platinum (Troy Ounce)
    case XRH = "XRH"; // Rhodium (Troy Ounce)
    case ZNC = "ZNC"; // Zinc

    public function getDescription(): string
    {
        return match ($this) {
            Metal::ALU => 'Aluminum',
            Metal::ANTIMONY => 'Antimony',
            Metal::BITUMEN => 'Bitumen',
            Metal::BRASS => 'Brass',
            Metal::BRONZE => 'Bronze',
            Metal::GALLIUM => 'Gallium',
            Metal::INDIUM => 'Indium',
            Metal::IRD => 'Iridium (Troy Ounce)',
            Metal::IRON => 'Iron Ore',
            Metal::LBXAG => 'LBMA Silver',
            Metal::LBXAUAM => 'LBMA Gold Am',
            Metal::LBXAUPM => 'LBMA Gold Pm',
            Metal::LBXPDAM => 'LBMA Palladium Am',
            Metal::LBXPDPM => 'LBMA Palladium Pm',
            Metal::LBXPTAM => 'LBMA Platinum Am',
            Metal::LBXPTPM => 'LBMA Platinum Pm',
            Metal::LCO => 'Cobalt (Troy Ounce)',
            Metal::LEAD => 'Lead',
            Metal::LITHIUM => 'Lithium',
            Metal::LME_ALU => 'LME Aluminium',
            Metal::LME_LEAD => 'LME Lead',
            Metal::LME_NI => 'LME Nickel',
            Metal::LME_TIN => 'LME Tin',
            Metal::LME_XCU => 'LME Copper',
            Metal::LME_ZNC => 'LME Zinc',
            Metal::MG => 'Magnesium',
            Metal::MN => 'Manganese',
            Metal::MO => 'Molybdenum',
            Metal::ND => 'Neodymium',
            Metal::NI => 'Nickel',
            Metal::OSMIUM => 'Osmium',
            Metal::RHENIUM => 'Rhenium',
            Metal::RUTH => 'Ruthenium',
            Metal::STEEL_HR => 'LME Steel HRC FOB China',
            Metal::STEEL_RE => 'LME Steel Rebar FOB Turkey',
            Metal::STEEL_SC => 'LME Steel Scrap CFR Turkey',
            Metal::TE => 'Tellurium',
            Metal::TIN => 'Tin',
            Metal::TUNGSTEN => 'Tungsten',
            Metal::URANIUM => 'Uranium',
            Metal::XAG_AHME => 'Ahmedabad Silver',
            Metal::XAG_BANG => 'Bangalore Silver',
            Metal::XAG_CHEN => 'Chennai Silver',
            Metal::XAG_COIM => 'Coimbatore Silver',
            Metal::XAG_DELH => 'Delhi Silver',
            Metal::XAG_HYDE => 'Hyderabad Silver',
            Metal::XAG_KOCH => 'Kochi Silver',
            Metal::XAG_KOLK => 'Kolkata Silver',
            Metal::XAG_MUMB => 'Mumbai Silver',
            Metal::XAG_SURA => 'Surat Silver',
            Metal::XAG => 'Silver (Troy Ounce)',
            Metal::XAU_AHME => 'Ahmedabad Gold',
            Metal::XAU_BANG => 'Bangalore Gold',
            Metal::XAU_CHEN => 'Chennai Gold',
            Metal::XAU_COIM => 'Coimbatore Gold',
            Metal::XAU_DELH => 'Delhi Gold',
            Metal::XAU_HYDE => 'Hyderabad Gold',
            Metal::XAU_KOCH => 'Kochi Gold',
            Metal::XAU_KOLK => 'Kolkata Gold',
            Metal::XAU_MUMB => 'Mumbai Gold',
            Metal::XAU_SURA => 'Surat Gold',
            Metal::XAU => 'Gold (Troy Ounce)',
            Metal::XCU => 'Copper',
            Metal::XPD => 'Palladium (Troy Ounce)',
            Metal::XPT => 'Platinum (Troy Ounce)',
            Metal::XRH => 'Rhodium (Troy Ounce)',
            Metal::ZNC => 'Zinc',
        };
    }
}
