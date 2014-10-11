using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace ParkingProba
{
    public class Location
    {
        public String Address;
        public Double GeoLat;
        public Double GeoLong;

        public Double Distance(Location location1, Location location2)
        {
            var R = 6371; // km
            var φ1 = DegreeToRadian(location1.GeoLat);
            var φ2 = DegreeToRadian(location2.GeoLat);
            var Δφ = DegreeToRadian(location2.GeoLat - location1.GeoLat);
            var Δλ = DegreeToRadian(location2.GeoLong - location1.GeoLong);

            var a = Math.Pow(Math.Sin(Δφ / 2), 2) + Math.Cos(φ1) * Math.Cos(φ2) * Math.Pow(Math.Sin(Δλ / 2), 2);
            var c = 2 * Math.Atan2(Math.Sqrt(a), Math.Sqrt(1 - a));

            return R * c;
        }

        private double DegreeToRadian(double angle)
        {
            return Math.PI * angle / 180.0;
        }
    }
}
