using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace ParkingProba
{
    public class Parking
    {
        public Location Location;
        public Int32 MaxParkingSpotsCount;

        public List<ParkingSpot> ParkingSpots = new List<ParkingSpot>();

        public Parking(Location location, Int32 maxParkingSpotsCount)
        {
            Location = location;
            MaxParkingSpotsCount = maxParkingSpotsCount;

            for (int i = 0; i < MaxParkingSpotsCount; i++)
            {
                ParkingSpots.Add(new ParkingSpot());
            }
        }

        public Int32 FreeParkingSpotsCount
        {
            get { return ParkingSpots.Count(o => o.IsFree); }
        }

        public List<ParkingSpot> FreeParkingSpots
        {
            get { return ParkingSpots.FindAll(o => o.IsFree); }
        }

         
    }
}
