using System;
using System.Collections.Generic;
using System.Collections;
using System.Linq;
using System.Text;

namespace ParkingProba
{
    public class ParkingSpot
    {
        /// <summary>
        /// Na svako parkirno mjesto postavljen je senzor koji očitava je li parkirno mjesto slobodno ili 
        /// zauzeto te podatak šalje u središnji sustav. Senzor radi na principu očitanja promjene stanja, 
        /// što znači da poruku šalje samo u trenutcima kad ili na slobodno parkirno mjesto dođe vozilo 
        /// ili pak kad vozilo ode sa zauzetog parkirnog mjesta. 
        /// </summary>
        public Boolean IsFree;
        readonly Sensor _sensor = new Sensor();

        public ParkingSpot()
        {
            IsFree = true;

            _sensor.OnSensorSignal += (o, e) => { IsFree = !IsFree; };
            _sensor.RaiseEvent(); // samo probni
        }
    }
}
