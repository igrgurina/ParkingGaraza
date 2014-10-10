using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace ParkingProba
{
    internal class MapEngine
    {
        public Location CurrentLocation;

        /// <summary>
        /// Sustav također nudi mogućnost unosa trenutne lokacije
        /// na temelju čega daje prijedlog najbliže/najbližih objekata sa slobodnim parkirnim mjesto
        /// </summary>
        /// <returns></returns>
        public IEnumerable<ParkingSpot> SuggestParkingSpots()
        {
            return null;

        }
    }
}
